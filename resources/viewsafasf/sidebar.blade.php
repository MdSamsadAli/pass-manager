<div class="col-lg-4 sidebar position-relative m-2">
    <div class="fix-sidebar">
        <div class="p-4">
            <div class="title">
                <h2>Categories</h2>
            </div>
            <ul>
                <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}"><a
                        href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="{{ request()->routeIs('front.bankdetails') ? 'active' : '' }}"><a
                        href="{{ route('front.bankdetails') }}">Bank Details</a></li>
                <li class="{{ request()->routeIs('front.educationinfo') ? 'active' : '' }}"><a
                        href="{{ route('front.educationinfo') }}">Education Info</a></li>
                <li class="{{ request()->routeIs('front.notes') ? 'active' : '' }}"><a
                        href="{{ route('front.notes') }}">Notes</a></li>
                <li class="{{ request()->routeIs('front.blogs') ? 'active' : '' }}"><a
                        href="{{ route('front.blogs') }}">Blogs</a></li>
                <li class="{{ request()->routeIs('front.drivinglicence') ? 'active' : '' }}"><a
                        href="{{ route('front.drivinglicence') }}">Driving Licence</a></li>
                <li class="{{ request()->routeIs('front.socialmedia') ? 'active' : '' }}">
                    <a href="{{ route('front.socialmedia') }}">Social Media</a>
                </li>
                {{-- <li><a href="{{ route('front.socialmedia') }}">Social Media</a></li> --}}
            </ul>
        </div>
    </div>
</div>
