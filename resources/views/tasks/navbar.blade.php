<nav class="navbar navbar-expand-lg " style="background-color: #e3f2fd;">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{route('tasks.index')}}">Tasks</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('tasks.create')}}">Create new Task</a>
                </li>

            </ul>
            Hi, {{ auth()->user()->name }}
            <a class="nav-link" href="{{route('logout')}}">Logout</a>
        </div>
    </div>
</nav>
