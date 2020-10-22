<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-item active">
                <a class="nav-link" href="/panel/home">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle"><i class="fas fa-user"></i> Admin</a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('panel.admin.list') }}"><i class="fas fa-list"></i> List</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('panel.admin.new') }}"><i class="fas fa-plus"></i> Add New</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle"><i class="fas fa-user"></i> User</a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('panel.user.list') }}"><i class="fas fa-list"></i> List</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('panel.user.new') }}"><i class="fas fa-plus"></i> Add New</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle"><i class="fas fa-user"></i> Category</a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('panel.category.list') }}"><i class="fas fa-list"></i> List</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('panel.category.new') }}"><i class="fas fa-plus"></i> Add New</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle"><i class="fas fa-user"></i> Publisher</a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('panel.publisher.list') }}"><i class="fas fa-list"></i> List</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('panel.publisher.new') }}"><i class="fas fa-plus"></i> Add New</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle"><i class="fas fa-user"></i> Author</a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('panel.author.list') }}"><i class="fas fa-list"></i> List</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('panel.author.new') }}"><i class="fas fa-plus"></i> Add New</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle"><i class="fas fa-user"></i> Book</a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('panel.book.list') }}"><i class="fas fa-list"></i> List</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('panel.book.new') }}"><i class="fas fa-plus"></i> Add New</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="{{ route('panel.issue.list') }}"><i class="fas fa-user"></i> Issue</a>
            </li>

        </ul>
    </nav>

    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>
