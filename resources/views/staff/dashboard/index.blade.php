@extends('layouts.app')
@section('content')
<h1 class="h3 mb-3">Dashboard</h1>
<div class="row">
    <div class="col-sm-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col mt-0">
                        <h5 class="card-title">Income</h5>
                    </div>

                    <div class="col-auto">
                        <div class="stat text-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign align-middle"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                        </div>
                    </div>
                </div>
                <h1 class="mt-1 mb-3">$47.482</h1>
                <div class="mb-0">
                    <span class="badge badge-success-light"> <i class="mdi mdi-arrow-bottom-right"></i> 3.65% </span>
                    <span class="text-muted">Since last week</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col mt-0">
                        <h5 class="card-title">Orders</h5>
                    </div>

                    <div class="col-auto">
                        <div class="stat text-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-bag align-middle"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                        </div>
                    </div>
                </div>
                <h1 class="mt-1 mb-3">2.542</h1>
                <div class="mb-0">
                    <span class="badge badge-danger-light"> <i class="mdi mdi-arrow-bottom-right"></i> -5.25% </span>
                    <span class="text-muted">Since last week</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col mt-0">
                        <h5 class="card-title">Activity</h5>
                    </div>

                    <div class="col-auto">
                        <div class="stat text-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-activity align-middle"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>
                        </div>
                    </div>
                </div>
                <h1 class="mt-1 mb-3">16.300</h1>
                <div class="mb-0">
                    <span class="badge badge-success-light"> <i class="mdi mdi-arrow-bottom-right"></i> 4.65% </span>
                    <span class="text-muted">Since last week</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col mt-0">
                        <h5 class="card-title">Revenue</h5>
                    </div>

                    <div class="col-auto">
                        <div class="stat text-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart align-middle"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                        </div>
                    </div>
                </div>
                <h1 class="mt-1 mb-3">$20.120</h1>
                <div class="mb-0">
                    <span class="badge badge-success-light"> <i class="mdi mdi-arrow-bottom-right"></i> 2.35% </span>
                    <span class="text-muted">Since last week</span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 col-lg-6 d-flex">
        <div class="card flex-fill">
            <div class="card-header">
                <div class="card-actions float-end">
                    <div class="dropdown position-relative">
                        <a href="#" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false" class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal align-middle"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                        </a>

                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </div>
                </div>
                <h5 class="card-title mb-0">Top Selling Products</h5>
            </div>
            <table class="table table-borderless my-0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th class="d-none d-xxl-table-cell">Company</th>
                        <th class="d-none d-xl-table-cell">Assigned</th>
                        <th class="d-none d-xl-table-cell text-end">Orders</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <div class="bg-light rounded-2">
                                        <img class="p-2" src="img/icons/brand-4.svg">
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <strong>Aurora</strong>
                                    <div class="text-muted">
                                        UI Kit
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="d-none d-xxl-table-cell">
                            <strong>Lechters</strong>
                            <div class="text-muted">
                                Real Estate
                            </div>
                        </td>
                        <td class="d-none d-xl-table-cell">
                            <strong>Vanessa Tucker</strong>
                            <div class="text-muted">
                                HTML, JS, React
                            </div>
                        </td>
                        <td class="d-none d-xl-table-cell text-end">
                            520
                        </td>
                        <td>
                            <span class="badge badge-success-light">In progress</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <div class="bg-light rounded-2">
                                        <img class="p-2" src="img/icons/brand-1.svg">
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <strong>Bender</strong>
                                    <div class="text-muted">
                                        Dashboard
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="d-none d-xxl-table-cell">
                            <strong>Cellophane Transportation</strong>
                            <div class="text-muted">
                                Transportation
                            </div>
                        </td>
                        <td class="d-none d-xl-table-cell">
                            <strong>William Harris</strong>
                            <div class="text-muted">
                                HTML, JS, Vue
                            </div>
                        </td>
                        <td class="d-none d-xl-table-cell text-end">
                            240
                        </td>
                        <td>
                            <span class="badge badge-warning-light">Paused</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <div class="bg-light rounded-2">
                                        <img class="p-2" src="img/icons/brand-5.svg">
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <strong>Camelot</strong>
                                    <div class="text-muted">
                                        Dashboard
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="d-none d-xxl-table-cell">
                            <strong>Clemens</strong>
                            <div class="text-muted">
                                Insurance
                            </div>
                        </td>
                        <td class="d-none d-xl-table-cell">
                            <strong>Darwin</strong>
                            <div class="text-muted">
                                HTML, JS, Laravel
                            </div>
                        </td>
                        <td class="d-none d-xl-table-cell text-end">
                            180
                        </td>
                        <td>
                            <span class="badge badge-success-light">In progress</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <div class="bg-light rounded-2">
                                        <img class="p-2" src="img/icons/brand-2.svg">
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <strong>Edison</strong>
                                    <div class="text-muted">
                                        UI Kit
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="d-none d-xxl-table-cell">
                            <strong>Affinity Investment Group</strong>
                            <div class="text-muted">
                                Finance
                            </div>
                        </td>
                        <td class="d-none d-xl-table-cell">
                            <strong>Vanessa Tucker</strong>
                            <div class="text-muted">
                                HTML, JS, React
                            </div>
                        </td>
                        <td class="d-none d-xl-table-cell text-end">
                            410
                        </td>
                        <td>
                            <span class="badge badge-danger-light">Cancelled</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <div class="bg-light rounded-2">
                                        <img class="p-2" src="img/icons/brand-3.svg">
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <strong>Fusion</strong>
                                    <div class="text-muted">
                                        Dashboard
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="d-none d-xxl-table-cell">
                            <strong>Konsili</strong>
                            <div class="text-muted">
                                Retail
                            </div>
                        </td>
                        <td class="d-none d-xl-table-cell">
                            <strong>Christina Mason</strong>
                            <div class="text-muted">
                                HTML, JS, Vue
                            </div>
                        </td>
                        <td class="d-none d-xl-table-cell text-end">
                            250
                        </td>
                        <td>
                            <span class="badge badge-warning-light">Paused</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-12 col-lg-6 d-flex">
        <div class="card flex-fill">
            <div class="card-header">
                <div class="card-actions float-end">
                    <div class="dropdown position-relative">
                        <a href="#" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false" class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal align-middle"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                        </a>

                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </div>
                </div>
                <h5 class="card-title mb-0">Top Selling Products</h5>
            </div>
            <table class="table table-borderless my-0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th class="d-none d-xxl-table-cell">Company</th>
                        <th class="d-none d-xl-table-cell">Assigned</th>
                        <th class="d-none d-xl-table-cell text-end">Orders</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <div class="bg-light rounded-2">
                                        <img class="p-2" src="img/icons/brand-4.svg">
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <strong>Aurora</strong>
                                    <div class="text-muted">
                                        UI Kit
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="d-none d-xxl-table-cell">
                            <strong>Lechters</strong>
                            <div class="text-muted">
                                Real Estate
                            </div>
                        </td>
                        <td class="d-none d-xl-table-cell">
                            <strong>Vanessa Tucker</strong>
                            <div class="text-muted">
                                HTML, JS, React
                            </div>
                        </td>
                        <td class="d-none d-xl-table-cell text-end">
                            520
                        </td>
                        <td>
                            <span class="badge badge-success-light">In progress</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <div class="bg-light rounded-2">
                                        <img class="p-2" src="img/icons/brand-1.svg">
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <strong>Bender</strong>
                                    <div class="text-muted">
                                        Dashboard
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="d-none d-xxl-table-cell">
                            <strong>Cellophane Transportation</strong>
                            <div class="text-muted">
                                Transportation
                            </div>
                        </td>
                        <td class="d-none d-xl-table-cell">
                            <strong>William Harris</strong>
                            <div class="text-muted">
                                HTML, JS, Vue
                            </div>
                        </td>
                        <td class="d-none d-xl-table-cell text-end">
                            240
                        </td>
                        <td>
                            <span class="badge badge-warning-light">Paused</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <div class="bg-light rounded-2">
                                        <img class="p-2" src="img/icons/brand-5.svg">
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <strong>Camelot</strong>
                                    <div class="text-muted">
                                        Dashboard
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="d-none d-xxl-table-cell">
                            <strong>Clemens</strong>
                            <div class="text-muted">
                                Insurance
                            </div>
                        </td>
                        <td class="d-none d-xl-table-cell">
                            <strong>Darwin</strong>
                            <div class="text-muted">
                                HTML, JS, Laravel
                            </div>
                        </td>
                        <td class="d-none d-xl-table-cell text-end">
                            180
                        </td>
                        <td>
                            <span class="badge badge-success-light">In progress</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <div class="bg-light rounded-2">
                                        <img class="p-2" src="img/icons/brand-2.svg">
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <strong>Edison</strong>
                                    <div class="text-muted">
                                        UI Kit
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="d-none d-xxl-table-cell">
                            <strong>Affinity Investment Group</strong>
                            <div class="text-muted">
                                Finance
                            </div>
                        </td>
                        <td class="d-none d-xl-table-cell">
                            <strong>Vanessa Tucker</strong>
                            <div class="text-muted">
                                HTML, JS, React
                            </div>
                        </td>
                        <td class="d-none d-xl-table-cell text-end">
                            410
                        </td>
                        <td>
                            <span class="badge badge-danger-light">Cancelled</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <div class="bg-light rounded-2">
                                        <img class="p-2" src="img/icons/brand-3.svg">
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <strong>Fusion</strong>
                                    <div class="text-muted">
                                        Dashboard
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="d-none d-xxl-table-cell">
                            <strong>Konsili</strong>
                            <div class="text-muted">
                                Retail
                            </div>
                        </td>
                        <td class="d-none d-xl-table-cell">
                            <strong>Christina Mason</strong>
                            <div class="text-muted">
                                HTML, JS, Vue
                            </div>
                        </td>
                        <td class="d-none d-xl-table-cell text-end">
                            250
                        </td>
                        <td>
                            <span class="badge badge-warning-light">Paused</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection