<!-- Dropezone CSS -->
<link rel="stylesheet" href="{{ asset('css/dropzone.css') }}">
<!-- CoreUI CSS -->
<link rel="stylesheet" href="{{ url('/') }}{{ mix('css/backend.css') }}" crossorigin="anonymous">
<link rel="stylesheet" href="{{ url('/') }}{{ mix('css/app.css') }}" crossorigin="anonymous">
<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

@yield('third_party_stylesheets')

@livewireStyles

@stack('page_css')
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap');
</style>
<style>

body {
    margin: 0;
    overflow-x: hidden;
   font-family: 'Poppins', sans-serif !important;
    font-size: 0.805rem;
    font-weight: 400;
    line-height: 1.5;
    text-align: left;
    color: #3c4b64;
    background-color: #ebedef;
}


.hokkie {
    color: #FF9800 !important;
    letter-spacing: 0.2rem;
   }
.c-sidebar {
    color: {{settings()->link_color}} !important;
    background:{{settings()->bg_sidebar}} !important;
}
.c-sidebar-nav-link .c-sidebar-nav-dropdown-toggle {
    color: #000 !important;
}


@media (hover: hover), (-ms-high-contrast: none)
.c-sidebar .c-sidebar-nav-link:hover, .c-sidebar .c-sidebar-nav-dropdown-toggle:hover {
    color: {{settings()->bg_sidebar_link_hover}} !important;
   background:{{settings()->bg_sidebar_hover}} !important;
}

.c-sidebar .c-sidebar-nav-link .c-sidebar-nav-icon, .c-sidebar .c-sidebar-nav-dropdown-toggle .c-sidebar-nav-icon {
 color: {{settings()->bg_sidebar_link}} !important;
}


.c-sidebar .c-sidebar-nav-link.c-active, .c-sidebar .c-active.c-sidebar-nav-dropdown-toggle {
 color: {{settings()->bg_sidebar_link_hover}} !important;
  background: rgba(255, 255, 255, 0.05);
}

.c-sidebar .c-sidebar-nav-link.c-active .c-sidebar-nav-icon, .c-sidebar .c-active.c-sidebar-nav-dropdown-toggle .c-sidebar-nav-icon {
   color: {{settings()->bg_sidebar_link_hover}} !important;
}
.c-sidebar .c-sidebar-nav-link, .c-sidebar .c-sidebar-nav-dropdown-toggle {
    color: {{settings()->bg_sidebar_link}} !important;
    background: transparent;
}

.page-item.active .page-link {
    z-index: 3;
    color: #fff;
    background-color: {{settings()->btn_color}} !important;
    border-color: {{settings()->btn_color}} !important;
}

.c-sidebar .c-sidebar-nav-link.c-active, .c-sidebar .c-active.c-sidebar-nav-dropdown-toggle {
  color: #fff;
  background-color: {{settings()->bg_sidebar_aktif}} !important;
}
.c-sidebar .c-sidebar-nav-link.c-active .c-sidebar-nav-icon, .c-sidebar .c-active.c-sidebar-nav-dropdown-toggle .c-sidebar-nav-icon {
  color: {{settings()->bg_sidebar_link_hover}} !important;
}
.c-sidebar .c-sidebar-nav-link:focus, .c-sidebar .c-sidebar-nav-dropdown-toggle:focus {
  outline: none;
}


@media (hover: hover), (-ms-high-contrast: none) {
  .c-sidebar .c-sidebar-nav-link:hover, .c-sidebar .c-sidebar-nav-dropdown-toggle:hover {
     color: {{settings()->bg_sidebar_link_hover}} !important;
    background: {{settings()->bg_sidebar_hover}} !important;
  }
  .c-sidebar .c-sidebar-nav-link:hover .c-sidebar-nav-icon, .c-sidebar .c-sidebar-nav-dropdown-toggle:hover .c-sidebar-nav-icon {
    color: {{settings()->bg_sidebar_link_hover}} !important;
  }
  .c-sidebar .c-sidebar-nav-link:hover.c-sidebar-nav-dropdown-toggle::after, .c-sidebar :hover.c-sidebar-nav-dropdown-toggle::after {
    background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 11 14'%3E%3Cpath fill='%23fff' d='M9.148 2.352l-4.148 4.148 4.148 4.148q0.148 0.148 0.148 0.352t-0.148 0.352l-1.297 1.297q-0.148 0.148-0.352 0.148t-0.352-0.148l-5.797-5.797q-0.148-0.148-0.148-0.352t0.148-0.352l5.797-5.797q0.148-0.148 0.352-0.148t0.352 0.148l1.297 1.297q0.148 0.148 0.148 0.352t-0.148 0.352z'/%3E%3C/svg%3E");
  }
}


.btn-danger {
    color: #fff;
    background-color: {{settings()->btn_cancel}} !important;
    border-color: {{settings()->btn_cancel}} !important;
}
.btn-primary {
    color: #fff;
    background-color: {{settings()->btn_color}} !important;
    border-color: {{settings()->btn_color}} !important;
}
.btn-success {
    color: #fff;
    background-color: #4caf50 !important;
    border-color: #321fdb !important;
}
</style>
