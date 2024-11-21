@php
    $subHeading = isset(app()->view->getSections()['pageSubHeading']) ?? '';
    if ($subHeading == '')
        $subHeading = app()->view->getSections()['title'] ?? '';

@endphp
<div id="kt_header" class="header header-fixed">
    <div class="container-fluid d-flex align-items-stretch justify-content-between">
        <div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
            <div id="kt_header_menu" class="header-menu header-menu-mobile header-menu-layout-default">
                <div
                    class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap my-4">
                    <div class="d-flex align-items-center flex-wrap mr-1">
                        <div class="d-flex align-items-baseline flex-wrap mr-5">
                            <h5 class="text-dark font-weight-bold my-1 mr-5">
                                {{ $subHeading }}
                            </h5>
                            @yield('breadcrumbs')
                        </div>
                    </div>

                    @if(isset($btnsList))

                        <div class="d-flex align-items-center">
                            @foreach ($btnsList as $btnItm)
                                @if(isset($btnItm['subopts']) && $btnItm['subopts'] != null)
                                    <div class="dropdown dropdown-inline ml-2" data-toggle="tooltip" data-placement="top"
                                        data-original-title="{{$btnItm['label']}}">
                                        <a href="javascript:;" class="btn btn-light-primary font-weight-bolder btn-sm"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                            <i class="fa fa-{{$btnItm['icon']}} p-0"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-md dropdown-menu-right p-0 m-0">
                                            <ul class="navi navi-hover">
                                                @foreach($btnItm['subopts'] as $subOption)

                                                    <li class="navi-item">
                                                        <a href="{{$subOption['link'] != '' ? url($subOption['link']) : 'javascript:;'}}"
                                                            class="navi-link">
                                                            <span class="navi-text">
                                                                {{$subOption['label']}}
                                                            </span>
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                @else

                                    @if(isset($btnItm['simple_btn']) and $btnItm['simple_btn'] <> null)
                                        <a href="{{$btnItm['link'] != '' ? url($btnItm['link']) : 'javascript:;'}}"
                                            class="{{$btnItm['class']}}" data-toggle="tooltip" aria-haspopup="true"
                                            aria-expanded="false">
                                            <?= $btnItm['simple_btn'] ?>
                                        </a>

                                    @else

                                        <a href="{{$btnItm['link'] != '' ? url($btnItm['link']) : 'javascript:;'}}"
                                            class="btn btn-icon btn-{{$btnItm['class']}} btn-xs ml-2" data-toggle="tooltip"
                                            title="{{$btnItm['label']}}" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-{{$btnItm['icon']}}"></i>
                                        </a>
                                    @endif
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="topbar">
            {{-- <x-top-bar-notifications /> --}}

            <div class="topbar-item">
                <a href="{{ url('/cleancache') }}">
                    <div class="btn btn-icon btn-clean btn-lg mr-1" title="Purge All">
                        <i class="menu-icon text-success fas fa-sync"></i>
                    </div>
                </a>
            </div>



            <div class="topbar-item">
                <div class="btn btn-icon btn-icon-mobile w-auto btn-clean d-flex align-items-center btn-lg px-2"
                    id="kt_quick_user_toggle">
                    <span class="text-muted font-weight-bold font-size-base d-none d-md-inline mr-1"></span>
                    <span
                        class="text-dark-50 font-weight-bolder font-size-base d-none d-md-inline mr-3">{{ Auth::user() ? Auth::user()->name : '??' }}</span>
                    <span class="symbol symbol-lg-35 symbol-25 symbol-light-success">
                        <span class="symbol-label font-size-h5 font-weight-bold">
                            <i class="fas fa-user"></i>
                        </span>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
@include('layouts.blocks.userpopup')