<!-- Google Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

<!-- Icon Library remixicon icon -->
<link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">

<!-- Fontawesome Icon CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<!-- Select2 css -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-selection{
        height: 26px !important;
        border-radius: 4px !important;
        border: 1px solid #ced4da !important;
        margin-bottom: 10px;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice{
        margin-top: 2px;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice__display{
        font-size: 12px;
        color: #1d1b31;
        font-weight: 500;
    }
    .select2-search--dropdown{
        padding: 0;
    }
    .select2-container--open .select2-dropdown--below{
        border: 1px solid #ced4da !important;
        border-top: none !important;
        border-radius: 4px !important;
        margin-top: -10px;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered{
        font-size: 12px;
        line-height: 25px;
    }
    .select2-container--default .select2-search--dropdown .select2-search__field{
        display: none;
    }
    .select2-results__options .select2-results__option.select2-results__option--disabled{
        font-size: 12px;
    }
    .select2-results__options::-webkit-scrollbar {
        width: 3px;
        background-color: #F5F5F5!important;
        background-clip: padding-box;
    }
    .select2-results__options::-webkit-scrollbar-track {
        background-color: #F5F5F5!important;
        background-clip: padding-box;
    }
    .select2-results__options::-webkit-scrollbar-thumb {
        background-clip: padding-box;
        background-color: rgb(216 220 241);
    }
    .select2-results__option--selectable{
        font-size: 12px;
        color: #1d1b31;
        font-weight: 500;
    }
</style>

<!-- DatePicker plugin -->
<link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />
<style>
    #datepicker{
        font-size: 13px;
        line-height: 18px;
    }
    .gj-icon{
        font-size: 18px!important;
        top: 8px!important;
        right: 8px!important;
    }
</style>

<!-- Toastr CSS & Modern Admin Styling -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<style>
    /* Modern Enterprise Toastr Styling */
    #toast-container {
        position: fixed;
        z-index: 9999999 !important;
        pointer-events: auto;
    }
    #toast-container > div {
        opacity: 1 !important;
        background: #FFFFFF !important;
        color: #0F172A !important;
        border: 1px solid #E2E8F0 !important;
        box-shadow: 0 20px 25px -5px rgba(15, 23, 42, 0.08), 0 8px 10px -6px rgba(15, 23, 42, 0.04), 0 0 0 1px rgba(15, 23, 42, 0.02) !important;
        border-radius: 10px !important;
        padding: 15px 16px 15px 52px !important;
        width: 360px !important;
        max-width: calc(100vw - 32px) !important;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
        position: relative !important;
        overflow: hidden !important;
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1) !important;
    }
    #toast-container > div:hover {
        box-shadow: 0 25px 30px -5px rgba(15, 23, 42, 0.12), 0 10px 12px -6px rgba(15, 23, 42, 0.06) !important;
    }
    #toast-container > .toast-success {
        border-left: 4px solid #10B981 !important;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%2310B981'%3E%3Cpath fill-rule='evenodd' d='M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z' clip-rule='evenodd'/%3E%3C/svg%3E") !important;
        background-size: 22px 22px !important;
        background-position: 16px 16px !important;
        background-repeat: no-repeat !important;
    }
    #toast-container > .toast-error {
        border-left: 4px solid #EF4444 !important;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23EF4444'%3E%3Cpath fill-rule='evenodd' d='M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm-1.72 6.97a.75.75 0 10-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 101.06 1.06L12 13.06l1.72 1.72a.75.75 0 101.06-1.06L13.06 12l1.72-1.72a.75.75 0 10-1.06-1.06L12 10.94l-1.72-1.72z' clip-rule='evenodd'/%3E%3C/svg%3E") !important;
        background-size: 22px 22px !important;
        background-position: 16px 16px !important;
        background-repeat: no-repeat !important;
    }
    #toast-container > .toast-warning {
        border-left: 4px solid #f95716 !important;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23f95716'%3E%3Cpath fill-rule='evenodd' d='M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003zM12 8.25a.75.75 0 01.75.75v3.75a.75.75 0 01-1.5 0V9a.75.75 0 01.75-.75zm0 8.25a.75.75 0 100-1.5.75.75 0 000 1.5z' clip-rule='evenodd'/%3E%3C/svg%3E") !important;
        background-size: 22px 22px !important;
        background-position: 16px 16px !important;
        background-repeat: no-repeat !important;
    }
    #toast-container > .toast-info {
        border-left: 4px solid #3B82F6 !important;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%233B82F6'%3E%3Cpath fill-rule='evenodd' d='M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 01.67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 11-.671-1.34l.041-.022zM12 9a.75.75 0 100-1.5.75.75 0 000 1.5z' clip-rule='evenodd'/%3E%3C/svg%3E") !important;
        background-size: 22px 22px !important;
        background-position: 16px 16px !important;
        background-repeat: no-repeat !important;
    }
    .toast-title {
        font-family: inherit !important;
        font-size: 13.5px !important;
        font-weight: 600 !important;
        color: #0F172A !important;
        letter-spacing: -0.01em !important;
        margin-bottom: 2px !important;
        line-height: 1.3 !important;
    }
    .toast-message {
        font-family: inherit !important;
        font-size: 12.5px !important;
        font-weight: 400 !important;
        line-height: 1.45 !important;
        color: #475569 !important;
    }
    .toast-close-button {
        top: 10px !important;
        right: 12px !important;
        font-size: 16px !important;
        font-weight: 400 !important;
        color: #94A3B8 !important;
        opacity: 0.7 !important;
        text-shadow: none !important;
        transition: all 0.2s ease !important;
    }
    .toast-close-button:hover {
        opacity: 1 !important;
        color: #0F172A !important;
    }
    #toast-container > div .toast-progress {
        height: 3px !important;
        bottom: 0 !important;
        opacity: 0.8 !important;
        border-radius: 0 0 10px 10px !important;
    }
    #toast-container > .toast-success .toast-progress { background-color: #10B981 !important; }
    #toast-container > .toast-error .toast-progress { background-color: #EF4444 !important; }
    #toast-container > .toast-warning .toast-progress { background-color: #f95716 !important; }
    #toast-container > .toast-info .toast-progress { background-color: #3B82F6 !important; }
</style>

<!-- Admin SCSS Styles -->
@vite(['resources/scss/admin/style.scss', 'resources/scss/admin/table.scss'])
