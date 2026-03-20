@php
$configData = Helper::appClasses();
@endphp

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme" style="background-color: #060709 !important;">

  <!-- ! Hide app brand if navbar-full -->
  @if(!isset($navbarFull))
  <div class="app-brand demo">
    <a href="{{url('/dashboards')}}" class="app-brand-link">
      <img src="{{asset('assets/images/logo/logo.png')}}" class="app-brand-logo demo" width="45" alt="PhDiZone Logo">
      <span class="app-brand-text demo menu-text fw-bold ms-3 fs-2 text-white text-uppercase">Walco</span>
      <!-- <label class="app-brand-logo demo">@include('_partials.macros',["width"=>25,"withbg"=>'var(--bs-primary)'])</label> -->
      <!-- <span class="app-brand-text demo menu-text fw-bold ms-2">{{config('variables.templateName')}}</span> -->
    </a>

    <!-- <a href="javascript:;" class="layout-menu-toggle menu-link text-large ms-auto">
      <span class="mdi mdi-chevron-double-right text-white fs-3"></span>
    </a> -->
    <a href="javascript:;" class="layout-menu-toggle menu-link text-large ms-auto">
      <span id="menuIcon" class="mdi mdi-menu text-white fs-3"></span>
    </a>
  </div>
  @endif

  <!-- <div class="menu-inner-shadow"></div> -->

  <ul class="menu-inner py-1">
    @foreach ($menuData[0]->menu as $menu)

    {{-- adding active and open class if child is active --}}

    {{-- menu headers --}}
    @if (isset($menu->menuHeader))
    <li class="menu-header fw-medium mt-4">
      <span class="menu-header-text">{{ __($menu->menuHeader) }}</span>
    </li>

    @else

    {{-- active menu method --}}
    @php
    $activeClass = null;
    $currentRouteName = Route::currentRouteName();

    if ($currentRouteName === $menu->slug) {
    $activeClass = 'active';
    }
    elseif (isset($menu->submenu)) {
    if (gettype($menu->slug) === 'array') {
    foreach($menu->slug as $slug){
    if (str_contains($currentRouteName,$slug) and strpos($currentRouteName,$slug) === 0) {
    $activeClass = 'active open';
    }
    }
    }
    else{
    if (str_contains($currentRouteName,$menu->slug) and strpos($currentRouteName,$menu->slug) === 0) {
    $activeClass = 'active open';
    }
    }

    }
    @endphp

    {{-- main menu --}}
    <li class="menu-item {{$activeClass}}">
      <a href="{{ isset($menu->url) ? url($menu->url) : 'javascript:;' }}" class="{{ isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}" @if (isset($menu->target) and !empty($menu->target)) target="_blank" @endif>
        @isset($menu->icon)
        <i class="{{ $menu->icon }}"></i>
        @endisset
        <div class="fs-7 fw-medium">{{ isset($menu->name) ? __($menu->name) : '' }}</div>
        @isset($menu->badge)
        <div class="badge bg-{{ $menu->badge[0] }} rounded-pill ms-auto">{{ $menu->badge[1] }}</div>

        @endisset
      </a>

      {{-- submenu --}}
      @isset($menu->submenu)
      @include('layouts.sections.menu.submenu',['menu' => $menu->submenu])
      @endisset
    </li>
    @endif
    @endforeach
  </ul>

</aside>
<script>
  document.querySelector('.layout-menu-toggle').addEventListener('click', function () {
    const icon = document.getElementById('menuIcon');

    if(icon.classList.contains('mdi-menu')){
        icon.classList.remove('mdi-menu');
        icon.classList.add('mdi-filter-variant');
    }else{
        icon.classList.remove('mdi-filter-variant');
        icon.classList.add('mdi-menu');
    }
  });
</script>

<!-- <a href="{{url('/dashboards')}}" class="app-brand-link">
  <img src="{{asset('assets/images/phdizone_logo.png')}}" class="app-brand-logo demo w-100" alt="Phdizone Logo">
</a> -->