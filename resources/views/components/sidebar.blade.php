<div class="sidebar-content">
    {{-- user --}}
    <div class="user">
        <div class="avatar-sm float-left mr-2">
            <img src="{{ asset('asset/img/dummy/profile-placeholder.png') }}" alt="profile photo admin"
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

            {{-- <div class="collapse in" id="collapseExample">
                <ul class="nav">
                    <li>
                        <a href="{{ route('admin.profile') }}">
                            <span class="link-collapse">Profil Saya</span>
                        </a>
                    </li>
                </ul>
            </div> --}}
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
        {{-- book --}}
        <li class="nav-item @if ($currentNav == 'book') active @endif">
            <a data-toggle="collapse" href="#bookMenu">
                <i class="fas fa-book"></i>
                <p>Buku</p>
                <span class="caret"></span>
            </a>
            <div class="collapse" id="bookMenu">
                <ul class="nav nav-collapse">
                    <li class="@if ($currentNavChild == 'library') active @endif">
                        <a href="{{ route('car.index') }}">
                            <span class="sub-item">Perpustakaan</span>
                        </a>
                    </li>
                    <li class="@if ($currentNavChild == 'ebook') active @endif">
                        <a href="{{ route('car.index') }}">
                            <span class="sub-item">E-Book</span>
                        </a>
                    </li>
                    <li class="@if ($currentNavChild == 'addBook') active @endif">
                        <a href="{{ route('car.index') }}">
                            <span class="sub-item">Tambah Buku</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        {{-- student --}}
        <li class="nav-item @if ($currentNav == 'student') active @endif">
            <a data-toggle="collapse" href="#studentMenu">
                <i class="fas fa-user-graduate"></i>
                <p>Siswa</p>
                <span class="caret"></span>
            </a>
            <div class="collapse" id="studentMenu">
                <ul class="nav nav-collapse">
                    <li class="@if ($currentNavChild == 'student') active @endif">
                        <a href="{{ route('car.index') }}">
                            <span class="sub-item">Pinjam</span>
                        </a>
                    </li>
                    <li class="@if ($currentNavChild == 'fines') active @endif">
                        <a href="{{ route('car.index') }}">
                            <span class="sub-item">Denda</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        {{-- category --}}
        <li class="nav-item @if ($currentNav == 'category') active @endif">
            <a href="{{ route('car.index') }}">
                <i class="fas fa-layer-group"></i>
                <p>Kategori</p>
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
                    <li class="@if ($currentNavChild == 'listBorrow') active @endif">
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
