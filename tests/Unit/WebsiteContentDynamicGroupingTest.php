<?php

use App\Models\WebsiteContent;

test('generic key parser detects standalone fields correctly (TEST A)', function () {
    $keys = ['title', 'description', 'badge', 'watermark', 'image', 'button_text', 'stat_suffix'];

    foreach ($keys as $key) {
        $parsed = WebsiteContent::parseContentKey($key);
        expect($parsed['is_group'])->toBeFalse()
            ->and($parsed['group'])->toBeNull()
            ->and($parsed['index'])->toBeNull()
            ->and($parsed['field'])->toBeNull();
    }
});

test('generic key parser detects simple repeating items correctly (TEST B)', function () {
    $parsed1 = WebsiteContent::parseContentKey('benefit_1');
    expect($parsed1['is_group'])->toBeTrue()
        ->and($parsed1['group'])->toBe('benefit')
        ->and($parsed1['index'])->toBe(1)
        ->and($parsed1['field'])->toBeNull();

    $parsed2 = WebsiteContent::parseContentKey('benefit_2');
    expect($parsed2['is_group'])->toBeTrue()
        ->and($parsed2['group'])->toBe('benefit')
        ->and($parsed2['index'])->toBe(2)
        ->and($parsed2['field'])->toBeNull();

    $parsed3 = WebsiteContent::parseContentKey('checklist_12');
    expect($parsed3['is_group'])->toBeTrue()
        ->and($parsed3['group'])->toBe('checklist')
        ->and($parsed3['index'])->toBe(12)
        ->and($parsed3['field'])->toBeNull();
});

test('generic key parser detects repeating items with subfields (TEST D)', function () {
    $parsed1 = WebsiteContent::parseContentKey('feature_1_title');
    expect($parsed1['is_group'])->toBeTrue()
        ->and($parsed1['group'])->toBe('feature')
        ->and($parsed1['index'])->toBe(1)
        ->and($parsed1['field'])->toBe('title');

    $parsed2 = WebsiteContent::parseContentKey('technology_2_description');
    expect($parsed2['is_group'])->toBeTrue()
        ->and($parsed2['group'])->toBe('technology')
        ->and($parsed2['index'])->toBe(2)
        ->and($parsed2['field'])->toBe('description');

    $parsed3 = WebsiteContent::parseContentKey('timeline_12_description');
    expect($parsed3['is_group'])->toBeTrue()
        ->and($parsed3['group'])->toBe('timeline')
        ->and($parsed3['index'])->toBe(12)
        ->and($parsed3['field'])->toBe('description');
});

test('group display title is generated dynamically with no hardcoding (TEST C)', function () {
    expect(WebsiteContent::buildGroupTitle('checklist'))->toBe('Checklist Items')
        ->and(WebsiteContent::buildGroupTitle('benefit'))->toBe('Benefit Items')
        ->and(WebsiteContent::buildGroupTitle('timeline'))->toBe('Timeline Items')
        ->and(WebsiteContent::buildGroupTitle('technology'))->toBe('Technology Items')
        ->and(WebsiteContent::buildGroupTitle('innovation'))->toBe('Innovation Items')
        ->and(WebsiteContent::buildGroupTitle('process'))->toBe('Process Items')
        ->and(WebsiteContent::buildGroupTitle('feature'))->toBe('Feature Items')
        ->and(WebsiteContent::buildGroupTitle('item'))->toBe('Items');
});

test('item display title respects database label and falls back generically (TEST F, TEST G)', function () {
    // Label present (TEST F)
    expect(WebsiteContent::buildItemTitle('benefit', 1, 'Core Engineering'))->toBe('Core Engineering')
        ->and(WebsiteContent::buildItemTitle('innovation', 1, 'Sustainable Construction'))->toBe('Sustainable Construction');

    // Label null/empty fallback (TEST G)
    expect(WebsiteContent::buildItemTitle('innovation', 1, null))->toBe('Innovation Item 1')
        ->and(WebsiteContent::buildItemTitle('benefit', 2, ''))->toBe('Benefit Item 2')
        ->and(WebsiteContent::buildItemTitle('technology', 3, null))->toBe('Technology Item 3')
        ->and(WebsiteContent::buildItemTitle('item', 1, null))->toBe('Item 1');
});

test('organizeSectionContent handles standalone fields, simple groups, and multi-field groups', function () {
    $records = [
        new WebsiteContent(['key' => 'title', 'value' => 'Company Story', 'type' => 'text']),
        new WebsiteContent(['key' => 'badge', 'value' => 'About', 'type' => 'text']),
        new WebsiteContent(['key' => 'innovation_1', 'value' => 'Green Concrete', 'type' => 'text', 'label' => 'Eco Material']),
        new WebsiteContent(['key' => 'innovation_2', 'value' => 'Modular Assembly', 'type' => 'text', 'label' => null]),
        new WebsiteContent(['key' => 'technology_1_name', 'value' => 'BIM 5D', 'type' => 'text', 'label' => 'BIM Tech']),
        new WebsiteContent(['key' => 'technology_1_desc', 'value' => '3D clash detection', 'type' => 'textarea', 'label' => 'Description']),
        new WebsiteContent(['key' => 'technology_2_name', 'value' => 'IoT Sensors', 'type' => 'text', 'label' => 'IoT Tech']),
        new WebsiteContent(['key' => 'technology_2_desc', 'value' => 'Real-time telemetry', 'type' => 'textarea', 'label' => 'Description']),
    ];

    $organized = WebsiteContent::organizeSectionContent($records, 'story', 'about');

    // Standalone
    expect($organized['standalone'])->toHaveKeys(['title', 'badge']);

    // Groups
    expect($organized['groups'])->toHaveKeys(['innovation', 'technology'])
        ->and($organized['groups']['innovation']['group_title'])->toBe('Innovation Items')
        ->and($organized['groups']['technology']['group_title'])->toBe('Technology Items');

    // Innovation items
    $innovationItems = $organized['groups']['innovation']['items'];
    expect($innovationItems)->toHaveKeys(['innovation_1', 'innovation_2'])
        ->and($innovationItems['innovation_1']['item_label'])->toBe('Eco Material')
        ->and($innovationItems['innovation_2']['item_label'])->toBe('Innovation Item 2');

    // Technology items
    $techItems = $organized['groups']['technology']['items'];
    expect($techItems)->toHaveKeys(['technology_1', 'technology_2'])
        ->and(count($techItems['technology_1']['records']))->toBe(2)
        ->and($techItems['technology_1']['title_preview'])->toBe('BIM 5D')
        ->and($techItems['technology_1']['desc_preview'])->toBe('3D clash detection');
});

test('organizeSectionContent enforces natural numeric sorting over string sorting (TEST E)', function () {
    $records = [
        new WebsiteContent(['key' => 'item_10_title', 'value' => 'Tenth Milestone']),
        new WebsiteContent(['key' => 'item_2_title', 'value' => 'Second Milestone']),
        new WebsiteContent(['key' => 'item_1_title', 'value' => 'First Milestone']),
        new WebsiteContent(['key' => 'item_20_title', 'value' => 'Twentieth Milestone']),
        new WebsiteContent(['key' => 'item_3_title', 'value' => 'Third Milestone']),
    ];

    $organized = WebsiteContent::organizeSectionContent($records);
    $itemKeys = array_keys($organized['groups']['item']['items']);

    expect($itemKeys)->toBe(['item_1', 'item_2', 'item_3', 'item_10', 'item_20']);
});

test('malformed keys do not crash and fallback safely (TEST J)', function () {
    $malformed = [
        'feature_',
        'feature_x',
        'feature_abc',
        'feature_1_',
        'feature_1_title_extra',
        '',
        '___',
    ];

    foreach ($malformed as $key) {
        $parsed = WebsiteContent::parseContentKey($key);
        expect($parsed)->toBeArray()
            ->and(array_key_exists('is_group', $parsed))->toBeTrue();
    }

    $records = array_map(fn ($k) => new WebsiteContent(['key' => $k, 'value' => 'Test']), $malformed);
    $organized = WebsiteContent::organizeSectionContent($records);

    expect($organized)->toBeArray()
        ->and(array_key_exists('standalone', $organized))->toBeTrue()
        ->and(array_key_exists('groups', $organized))->toBeTrue();
});

test('completely unknown group names with no previous existence work 100% dynamically', function () {
    $records = [
        new WebsiteContent(['key' => 'futureproof_1', 'value' => 'Alpha Value', 'type' => 'text', 'label' => 'Custom Futureproof 1']),
        new WebsiteContent(['key' => 'futureproof_2', 'value' => 'Beta Value', 'type' => 'text']),
        new WebsiteContent(['key' => 'capability_1', 'value' => 'Deep Trenching', 'type' => 'text']),
        new WebsiteContent(['key' => 'capability_2', 'value' => 'Soil Nailing', 'type' => 'text']),
        new WebsiteContent(['key' => 'quantum_1_spec', 'value' => 'Subatomic Tolerances', 'type' => 'text']),
        new WebsiteContent(['key' => 'quantum_1_status', 'value' => 'Active Phase', 'type' => 'text']),
        new WebsiteContent(['key' => 'quantum_2_spec', 'value' => 'Laser Metrology', 'type' => 'text']),
        new WebsiteContent(['key' => 'quantum_2_status', 'value' => 'Commissioned', 'type' => 'text']),
    ];

    $organized = WebsiteContent::organizeSectionContent($records, 'random', 'test');

    expect($organized['groups'])->toHaveKeys(['futureproof', 'capability', 'quantum'])
        ->and($organized['groups']['futureproof']['group_title'])->toBe('Futureproof Items')
        ->and($organized['groups']['capability']['group_title'])->toBe('Capability Items')
        ->and($organized['groups']['quantum']['group_title'])->toBe('Quantum Items')
        ->and($organized['groups']['futureproof']['items']['futureproof_1']['item_label'])->toBe('Custom Futureproof 1')
        ->and($organized['groups']['futureproof']['items']['futureproof_2']['item_label'])->toBe('Futureproof Item 2')
        ->and(count($organized['groups']['quantum']['items']['quantum_1']['records']))->toBe(2)
        ->and(count($organized['groups']['quantum']['items']['quantum_2']['records']))->toBe(2);
});

