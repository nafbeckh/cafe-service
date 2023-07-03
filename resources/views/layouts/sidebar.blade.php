<nav class="mt-2">
	<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <li class="nav-item">
        <a href="{{ route('dashboard') }}" class="nav-link {{ $title == 'Dashboard' ? 'active' : '' }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
        </a>
    </li>

    <li class="nav-header">DATA MASTER</li>
    <li class="nav-item">      
        <a href="{{ route('kategori.index') }}" class="nav-link {{ $title == 'Kategori Menu' ? 'active' : '' }}">
          <i class="nav-icon fas fa-list-ol"></i>
          <p>Kategori Menu</p>
      </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('menu.index') }}" class="nav-link {{ $title == 'Menu' ? 'active' : '' }}">
            <i class="nav-icon fas fa-hamburger"></i>
            <p>Menu</p>
        </a>
      </li>

    <li class="nav-item">
        <a href="{{ route('meja.index') }}" class="nav-link {{ $title == 'Meja' ? 'active' : '' }}">
            <i class="nav-icon fa fa-store-alt"></i>
            <p>Meja</p>
        </a>
    </li>

    <li class="nav-header">LAPORAN</li>
    <li class="nav-item">
      <a href="" class="nav-link {{ $title == 'Laporan Pemesanan' ? 'active' : '' }}">
          <i class="nav-icon fas fa-file-alt"></i>
          <p>Laporan Pemesanan</p>
      </a>
    </li>
  
    <li class="nav-header">SISTEM</li>
    <li class="nav-item">
        <a href="{{ route('user.index') }}" class="nav-link {{ $title == 'User' ? 'active' : '' }}">
          <i class="nav-icon fas fa-users"></i>
          <p>User</p>
      </a>
    </li>
  
    @hasrole('admin')
    <li class="nav-item">
        <a href="{{ route('setting.cafe') }}" class="nav-link {{ $title == 'Setting Cafe' ? 'active' : '' }}">
            <i class="nav-icon fas fa-store"></i>
            <p>Cafe</p>
        </a>
    </li>
    @endhasrole
  </ul>
</nav>
