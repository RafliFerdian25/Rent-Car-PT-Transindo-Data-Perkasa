<div class="sidebar-content">
    {{-- user --}}
    <div class="user">
        <div class="avatar-sm float-left mr-2">
            <img src="{{ asset('assets/img/dummy/profile-placeholder.png') }}" alt="profile photo admin"
                class="avatar-img rounded-circle">
        </div>
        <div class="info">
            <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                <span>Petugas
                    <span class="user-level">Administrator</span>
                    <span class="caret"></span>
                </span>
            </a>
            <div class="clearfix"></div>
        </div>
    </div>

    {{-- sidebar --}}
    <ul class="nav nav-primary">
        {{-- Daftar Mobil --}}
        <li class="nav-item @if ($currentNav == 'car') active @endif">
            <a href="{{ route('car.index') }}">
                <i class="fas fa-car"></i>
                <p>Daftar Mobil</p>
            </a>
        </li>
        {{-- rent --}}
        <li class="nav-item @if ($currentNav == 'rent') active @endif">
            <a data-toggle="collapse" href="#rentMenu">
                <i class="fas fa-box"></i>
                <p>Peminjaman</p>
                <span class="caret"></span>
            </a>
            <div class="collapse" id="rentMenu">
                <ul class="nav nav-collapse">
                    <li class="@if ($currentNavChild == 'index') active @endif">
                        <a href="{{ route('rent.index') }}">
                            <span class="sub-item">Daftar Pinjam</span>
                        </a>
                    </li>
                    @if (Auth::user()->role == 'customer')
                        <li class="@if ($currentNavChild == 'create') active @endif">
                            <a href="{{ route('rent.create') }}">
                                <span class="sub-item">Pinjam Mobil</span>
                            </a>
                        </li>
                    @endif
                    <li class="@if ($currentNavChild == 'history') active @endif">
                        <a href="{{ route('rent.history') }}">
                            <span class="sub-item">Riwayat Pinjam</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        {{-- logout --}}
        <li class="nav-item">
            <a href="/logout" onclick="logout()" class="hover-logout">
                <i class="fas fa-sign-out-alt"></i>
                <p>Logout</p>
            </a>
        </li>
    </ul>
</div>
