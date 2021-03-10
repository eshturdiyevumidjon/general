<div id="mySidenav" class="sidenav bg-primary px-0">
    @php $pr = \Illuminate\Support\Facades\Route::current()->getPrefix(); @endphp
    @if($pr != "admin/divisions" && $pr != "admin/positions" && $pr != "admin/users" && $pr != "admin/metka" && $pr != "admin/language" && $pr != "admin")
        <nav class="navbar navbar-dark bg-primary flex-column align-items-start p-0 pb-5">
            <a class="nav-link {{ url()->current() == url('/') ? 'active' : '' }}" href="{{ route('general.dashboard') }}" @click="persist('anotherOne')">
                {{ trans("messages.Dashboard") }}
            </a>
            
            <a class="nav-link text-white bg-primary" :class="{'active' : isShown1}" type="button" @click="persist('isShown1')" >
                {{ trans("messages.Datas") }} <i class="fas fa-angle-down"></i>
            </a>
            
            <div v-show="isShown1" id="collapseOne" class="navbar-collapse">
                <nav class="navbar-nav flex-column pl-4">
                    <a href="{{route('general.resource')}}" class="nav-link {{ url()->current() == route('general.resource') ? 'active' : '' }}">{{ trans("messages.Resources") }}</a>
                    <a href="{{route('general.exchange-index')}}" class="nav-link {{ url()->current() == route('general.exchange-index') ? 'active' : '' }}">{{ trans("messages.Data exchange") }}</a>
                </nav>
            </div>
            
            <a class="nav-link text-white bg-primary" :class="{'active' : isShown2}" type="button" @click="persist('isShown2')" >
                {{ trans("messages.Directories") }} <i class="fas fa-angle-down"></i>
            </a>
            
            <div v-show="isShown2" id="collapseTwo" class="navbar-collapse">
                <nav class="navbar-nav flex-column pl-4">
                    <a href="{{ route('general.directories.list_posts') }}" class="nav-link {{ url()->current() == route('general.directories.list_posts') ? 'active' : '' }}">{{ trans("messages.List of posts on rivers and canals") }}</a>
                    <a href="{{ route('general.directories.chimicil') }}" class="nav-link {{ url()->current() == route('general.directories.chimicil') ? 'active' : '' }}">{{ trans("messages.List of chemical compositions") }}</a>
                </nav>
            </div>

            <a class="nav-link {{ url()->current() == route('general.report.index') ? 'active' : '' }}" href="{{route('general.report.index')}}" @click="persist('anotherOne')">
                {{ trans("messages.Reports") }}
            </a>
            
            <a class="nav-link" href="#" @click="persist('anotherOne')">{{ trans("messages.References") }}</a>
        </nav>
    @else
        <nav class="navbar navbar-dark bg-primary flex-column align-items-start p-0 pb-5">
            <a id="users" class="nav-link {{ url()->current() == route('general.admin.users') ? 'active' : '' }}" href="{{route('general.admin.users')}}" @click="persist('anotherOne')">
                {{ trans("messages.Users") }}
            </a>
            <a class="nav-link text-white bg-primary" :class="{'active' : langs}" @click="persist('langs')" type="button">
                {{ trans("messages.Translations") }} <i class="fas fa-angle-down"></i>
            </a>
            <div v-show="langs" id="collapseThree" class="navbar-collapse">
                <nav class="navbar-nav flex-column pl-4">
                    <a class="nav-link {{ url()->current() == route('general.langs') ? 'active' : '' }}" href="{{ route('general.langs') }}">
                        {{ trans("messages.Lang") }}
                    </a>
                    <a class="nav-link {{ url()->current() == route('general.metki.list') ? 'active' : '' }}" href="{{ route('general.metki.list')}}">
                        {{ trans("messages.Terms") }}
                    </a>
                </nav>
            </div>
        </nav>
    @endif
</div>