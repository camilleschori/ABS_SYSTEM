<div id="sidebar">
    <div class="sidebar-wrapper active">


        <div class="sidebar-header position-relative">
            <div class="d-flex justify-content-between align-items-center">

                <div class="logo">
                    <a href="/">

                        <img src="{{ url('admin/assets/images/invoice-logo.png') }}" alt="" srcset="">
                        {{-- <span class="logo-text">المشجر الحديث</span> --}}
                    </a>
                </div>

                <div class="sidebar-toggler  x">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>



        <div class="sidebar-menu">
            <ul class="menu">


                <li class="sidebar-item">
                    <a href="/" class='sidebar-link'>
                        <i class="bi bi-house"></i>
                        <span>الصفحة الرئيسية</span>
                    </a>
                </li>

                @can('access roles')
                    <li class="sidebar-item">
                        <a href="{{ route('drugstore.roles-permissions.index') }}" class='sidebar-link'>
                            <i class="bi bi-lock"></i>
                            <span>الصلاحيات</span>
                        </a>
                    </li>
                @endcan

                @if (auth()->user()->type == 'drugstore' || auth()->user()->type == 'admin')
                    <li class="sidebar-item  has-sub">
                        <a href="#" class="sidebar-link">
                            <i class="bi bi-bag"></i>
                            <span>قسم المواد</span>
                        </a>

                        <ul class="submenu submenu-closed" style="--submenu-height: 774px;">


                            <li class="submenu-item ">
                                <a href="{{ route('drugstore.items.index') }}" class='submenu-link'>
                                    <i class="bi bi-capsule"></i>
                                    <span>تعريف المواد</span>
                                </a>
                            </li>

                            <li class="submenu-item ">
                                <a href="{{ route('drugstore.brands.index') }}" class='submenu-link'>
                                    <i class="bi bi-bookmarks"></i>
                                    <span>تعريف الوكالات</span>
                                </a>
                            </li>

                            <li class="submenu-item ">
                                <a href="{{ route('drugstore.price_groups.index') }}" class='submenu-link'>
                                    <i class="bi bi-currency-dollar"></i>
                                    <span>فئات السعر</span>
                                </a>
                            </li>


                            <li class="submenu-item ">
                                <a href="{{ route('drugstore.packages.index') }}" class='submenu-link'>
                                    <i class="bi bi-box"></i>
                                    <span>التغليف</span>
                                </a>
                            </li>


                            <li class="submenu-item ">
                                <a href="{{ route('drugstore.manufacturers.index') }}" class='submenu-link'>
                                    <i class="bi bi-house-down-fill"></i>
                                    <span>المصانع</span>
                                </a>
                            </li>

                            <li class="submenu-item ">
                                <a href="{{ route('drugstore.categories.index') }}" class='submenu-link'>
                                    <i class="bi bi-pie-chart"></i>
                                    <span>تصنيفات المواد</span>
                                </a>
                            </li>
                            <li class="submenu-item ">
                                <a href="{{ route('drugstore.stock.index') }}" class='submenu-link'>
                                    <i class="bi bi-box-seam"></i>
                                    <span>المخزن</span>
                                </a>
                            </li>

                        </ul>


                    </li>

                    <li class="sidebar-item  has-sub">
                        <a href="#" class="sidebar-link">
                            <i class="bi bi-currency-dollar"></i>
                            <span>قسم الحسابات</span>
                        </a>

                        <ul class="submenu submenu-closed" style="--submenu-height: 774px;">


                            <li class="submenu-item ">
                                <a href="{{ route('drugstore.accounts.index') }}" class='submenu-link'>
                                    <i class="bi bi-diagram-3"></i>
                                    <span>شجرة الحسابات</span>
                                </a>
                            </li>

                            <li class="submenu-item ">
                                <a href="{{ route('drugstore.transactions.index') }}" class='submenu-link'>
                                    <i class="bi bi-journal-bookmark"></i>
                                    <span>القيود</span>
                                </a>
                            </li>
                            <li class="submenu-item ">
                                <a href="{{ route('drugstore.bonds.index') }}" class='submenu-link'>
                                    <i class="bi bi-journal-bookmark"></i>
                                    <span>السندات</span>
                                </a>
                            </li>

                            <li class="submenu-item ">
                                <a href="{{ route('drugstore.operations.index') }}" class="submenu-link">
                                    <i class="bi bi-plus-slash-minus"></i>
                                    <span>عمليات المستودع</span>
                                </a>
                            </li>

                            <li class="submenu-item ">
                                <a href="{{ route('drugstore.accounting_operations.index') }}" class="submenu-link">
                                    <i class="bi bi-plus-slash-minus"></i>
                                    <span>عمليات محاسبية</span>
                                </a>
                            </li>

                            <li class="submenu-item ">
                                <a href="{{ route('drugstore.invoices.index') }}" class='submenu-link'>
                                    <i class="bi bi-cart"></i>
                                    <span>الوثائق</span>
                                </a>
                            </li>
                            <li class="submenu-item ">
                                <a href="{{ route('drugstore.settelments.index') }}" class='submenu-link'>
                                    <i class="bi bi-cart"></i>
                                    <span>الاستحصال</span>
                                </a>
                            </li>
                            <li class="submenu-item ">
                                <a href="{{ route('drugstore.cost_centers.index') }}" class='submenu-link'>
                                    <i class="bi bi-bank"></i>
                                    <span>مراكز الكلف</span>
                                </a>
                            </li>



                        </ul>


                    </li>

                    <li class="sidebar-item  has-sub">
                        <a href="#" class="sidebar-link">
                            <i class="bi bi-bar-chart-line"></i>
                            <span>قسم التقارير</span>
                        </a>

                        <ul class="submenu submenu-closed" style="--submenu-height: 774px;">


                            <li class="submenu-item ">
                                <a href="/drugstore/reports/general_ledger" class='submenu-link'>
                                    <i class="bi bi-journal-bookmark"></i>
                                    <span>دفتر الاستاذ</span>
                                </a>
                            </li>


                            <li class="submenu-item ">
                                <a href="/drugstore/reports/trial_balance" class='submenu-link'>
                                    <i class="bi bi-arrow-left-right"></i>
                                    <span>ميزان المراجعة</span>
                                </a>
                            </li>



                            <li class="submenu-item ">

                                <a href="/drugstore/reports/account_statment" class='submenu-link'>
                                    <i class="bi bi-wallet2"></i>
                                    <span>كشف مديونية</span>
                                </a>

                            </li>
                            <li class="submenu-item ">

                                <a href="/drugstore/reports/cost_centers" class='submenu-link'>
                                    <i class="bi bi-wallet2"></i>
                                    <span>كشف مراكز الكلف</span>
                                </a>

                            </li>




                            <li class="submenu-item ">
                                <a href="/drugstore/reports/material_movement" class='submenu-link'>
                                    <i class="bi bi-ui-checks"></i>
                                    <span>حركات المادة</span>
                                </a>
                            </li>


                            <li class="submenu-item ">
                                <a href="/drugstore/reports/warehouse_inventory" class='submenu-link'>
                                    <i class="bi bi-boxes"></i>
                                    <span>جرد المخزن</span>
                                </a>
                            </li>


                        </ul>

                    </li>

                    <li class="sidebar-item  has-sub">
                        <a href="#" class="sidebar-link">
                            <i class="bi bi-people"></i>
                            <span>قسم المستخدمين</span>
                        </a>

                        <ul class="submenu submenu-closed" style="--submenu-height: 774px;">


                            <li class="submenu-item ">
                                <a href="{{ route('drugstore.users.index') }}" class='submenu-link'>
                                    <i class="bi bi-person"></i>
                                    <span>تعريف المستخدمين</span>
                                </a>
                            </li>

                            <li class="submenu-item ">
                                <a href="{{ route('drugstore.profiles.index') }}" class='submenu-link'>
                                    <i class="bi bi-person-video2"></i>
                                    <span>الملفات الشخصية</span>
                                </a>
                            </li>

                            <li class="submenu-item ">
                                <a href="{{ route('drugstore.join_requests.index') }}" class='submenu-link'>
                                    <i class="bi bi-card-list"></i>
                                    <span>طلبات الانضمام</span>
                                </a>
                            </li>
                            <li class="submenu-item ">
                                <a href="{{ route('drugstore.promo_codes.index') }}" class='submenu-link'>
                                    <i class="bi bi-percent"></i>
                                    <span>اكواد الخصم</span>
                                </a>
                            </li>



                        </ul>


                    </li>

                    <li class="sidebar-item  has-sub">
                        <a href="#" class="sidebar-link">
                            <i class="bi bi-gear"></i>
                            <span>اقسام اخرى</span>
                        </a>

                        <ul class="submenu submenu-closed" style="--submenu-height: 774px;">


                            <li class="submenu-item ">
                                <a href="{{ route('drugstore.regions.index') }}" class='submenu-link'>
                                    <i class="bi bi-globe-americas"></i>
                                    <span>المناطق</span>
                                </a>
                            </li>

                            <li class="submenu-item ">
                                <a href="{{ route('drugstore.banners.index') }}" class='submenu-link'>
                                    <i class="bi bi-image"></i>
                                    <span>الاعلانات</span>
                                </a>
                            </li>

                            <li class="submenu-item ">
                                <a href="{{ route('drugstore.settings.index') }}" class='submenu-link'>
                                    <i class="bi bi-sliders"></i>
                                    <span>الاعدادات</span>
                                </a>
                            </li>




                        </ul>


                    </li>
                @endif


                @if (auth()->user()->type == 'bureau')
                    <li class="sidebar-item">
                        <a href="{{ route('bureau.stock.index') }}" class='sidebar-link'>
                            <i class="bi bi-box-seam"></i>
                            <span>المخزن</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a href="{{ route('bureau.invoices.index') }}" class='sidebar-link'>
                            <i class="bi bi-cart"></i>
                            <span>الوثائق</span>
                        </a>
                    </li>


                    <li class="sidebar-item">
                        <a href="/bureau/reports/general_ledger" class='sidebar-link'>
                            <i class="bi bi-journal-bookmark"></i>
                            <span>كشف حساب</span>
                        </a>
                    </li>


                    <li class="sidebar-item">
                        <a href="/bureau/reports/warehouse_inventory" class='sidebar-link'>
                            <i class="bi bi-boxes"></i>
                            <span>جرد المواد</span>
                        </a>
                    </li>
                @endif


                @if (Auth::check())
                    @if (Auth::user()->type === 'drugstore' || Auth::user()->type === 'admin')
                        <li class="sidebar-item">
                            <a href="{{ route('drugstore.logout') }}" class='sidebar-link text-danger'>
                                <i class="bi bi-box-arrow-right text-danger"></i>
                                <span>تسجيل الخروج</span>
                            </a>
                        </li>
                    @elseif(Auth::user()->type === 'bureau')
                        <li class="sidebar-item">
                            <a href="{{ route('bureau.logout') }}" class='sidebar-link text-danger'>
                                <i class="bi bi-box-arrow-right text-danger"></i>
                                <span>تسجيل الخروج</span>
                            </a>
                        </li>
                    @endif
                @endif
            </ul>


            <div class="theme-toggle d-flex gap-2  align-items-center justify-content-center mt-5">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true"
                    role="img" class="iconify iconify--system-uicons" width="20" height="20"
                    preserveAspectRatio="xMidYMid meet" viewBox="0 0 21 21">
                    <g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path
                            d="M10.5 14.5c2.219 0 4-1.763 4-3.982a4.003 4.003 0 0 0-4-4.018c-2.219 0-4 1.781-4 4c0 2.219 1.781 4 4 4zM4.136 4.136L5.55 5.55m9.9 9.9l1.414 1.414M1.5 10.5h2m14 0h2M4.135 16.863L5.55 15.45m9.899-9.9l1.414-1.415M10.5 19.5v-2m0-14v-2"
                            opacity=".3"></path>
                        <g transform="translate(-210 -1)">
                            <path d="M220.5 2.5v2m6.5.5l-1.5 1.5"></path>
                            <circle cx="220.5" cy="11.5" r="4"></circle>
                            <path d="m214 5l1.5 1.5m5 14v-2m6.5-.5l-1.5-1.5M214 18l1.5-1.5m-4-5h2m14 0h2">
                            </path>
                        </g>
                    </g>
                </svg>
                <div class="form-check form-switch fs-6">
                    <input class="form-check-input  me-0" type="checkbox" id="toggle-dark" style="cursor: pointer">
                    <label class="form-check-label"></label>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true"
                    role="img" class="iconify iconify--mdi" width="20" height="20"
                    preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                    <path fill="currentColor"
                        d="m17.75 4.09l-2.53 1.94l.91 3.06l-2.63-1.81l-2.63 1.81l.91-3.06l-2.53-1.94L12.44 4l1.06-3l1.06 3l3.19.09m3.5 6.91l-1.64 1.25l.59 1.98l-1.7-1.17l-1.7 1.17l.59-1.98L15.75 11l2.06-.05L18.5 9l.69 1.95l2.06.05m-2.28 4.95c.83-.08 1.72 1.1 1.19 1.85c-.32.45-.66.87-1.08 1.27C15.17 23 8.84 23 4.94 19.07c-3.91-3.9-3.91-10.24 0-14.14c.4-.4.82-.76 1.27-1.08c.75-.53 1.93.36 1.85 1.19c-.27 2.86.69 5.83 2.89 8.02a9.96 9.96 0 0 0 8.02 2.89m-1.64 2.02a12.08 12.08 0 0 1-7.8-3.47c-2.17-2.19-3.33-5-3.49-7.82c-2.81 3.14-2.7 7.96.31 10.98c3.02 3.01 7.84 3.12 10.98.31Z">
                    </path>
                </svg>
            </div>
        </div>
    </div>
</div>
