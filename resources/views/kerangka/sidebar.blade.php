<a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
    <div class="sidebar-brand-icon rotate-n-15">
        <i class="fas fa-laugh-wink"></i>
    </div>
    <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
</a>

<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item active">
    <a class="nav-link" href="{{ route('dashboard.index') }}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
</li>



<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
        aria-expanded="true" aria-controls="collapsePages">
        <i class="fas fa-fw fa-folder"></i>
        <span>Divisi</span>
    </a>
    <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="{{ route('ppic.janfar') }}">Janfar</a>
            <a class="collapse-item" href="{{ route('ppic.sawing')}}">Sawing</a>
            <a class="collapse-item" href="{{ route('ppic.cutting') }}">Cutting</a>
            <a class="collapse-item" href="{{ route('ppic.bending') }}">Bending</a>
            <a class="collapse-item" href="{{ route('ppic.press') }}">Press</a>
            <a class="collapse-item" href="{{ route('ppic.racking') }}">Racking</a>
            <a class="collapse-item" href="{{ route('ppic.rollforming') }}">Roll Forming</a>
            <a class="collapse-item" href="{{ route('ppic.spotwelding') }}">Spot Welding</a>
            <a class="collapse-item" href="{{ route('ppic.weldingaccesoris') }}">Welding Accessoris</a>
            <a class="collapse-item" href="{{ route('ppic.weldingshofiting1') }}">Welding Shofiting 1</a>
            <a class="collapse-item" href="{{ route('ppic.weldingshofiting2') }}">Welding Shofiting 2</a>
            <a class="collapse-item" href="{{ route('ppic.weldingdoor') }}">Welding Door</a>
        </div>
    </div>
</li>


{{-- <li class="nav-item active">
    <a class="nav-link" href="{{ route('ppic.janfar') }}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Janfar</span></a>
</li>

<li class="nav-item active">
    <a class="nav-link" href="{{ route('ppic.sawing')}}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Sawing</span></a>
</li>

<li class="nav-item active">
    <a class="nav-link" href="{{ route('ppic.cutting') }}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Cutting</span></a>
</li>

<li class="nav-item active">
    <a class="nav-link" href="{{ route('ppic.bending') }}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Bending</span></a>
</li>

<li class="nav-item active">
    <a class="nav-link" href="{{ route('ppic.press') }}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Press</span></a>
</li>

<li class="nav-item active">
    <a class="nav-link" href="{{ route('ppic.racking') }}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Racking</span></a>
</li>

<li class="nav-item active">
    <a class="nav-link" href="{{ route('ppic.rollforming') }}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Roll Forming</span></a>
</li>

<li class="nav-item active">
    <a class="nav-link" href="{{ route('ppic.spotwelding') }}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Spot Welding</span></a>
</li>

<li class="nav-item active">
    <a class="nav-link" href="{{ route('ppic.weldingaccesoris') }}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Welding Accessoris</span></a>
</li>

<li class="nav-item active">
    <a class="nav-link" href="{{ route('ppic.weldingshofiting1') }}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Welding Shofiting 1</span></a>
</li>

<li class="nav-item active">
    <a class="nav-link" href="{{ route('ppic.weldingshofiting2') }}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Welding Shofiting 2</span></a>
</li>

<li class="nav-item active">
    <a class="nav-link" href="{{ route('ppic.weldingdoor') }}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Welding Door</span></a>
</li> --}}



<!-- Nav Item - Pages Collapse Menu -->
<!-- <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
        aria-expanded="true" aria-controls="collapsePages">
        <i class="fas fa-fw fa-folder"></i>
        <span>Divisi</span>
    </a>
    <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Divisi</h6>
            <a class="collapse-item" href="#">Barang</a>
            <a class="collapse-item" href="#">Barang Masuk</a>
            <a class="collapse-item" href="#">Barang Keluar</a>
        </div>
    </div>
</li> -->


<!-- Nav Item - Tables -->
{{-- <li class="nav-item">
    <a class="nav-link" href="tables.html">
        <i class="fas fa-fw fa-table"></i>
        <span>Tables</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block"> --}}

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>



</ul>