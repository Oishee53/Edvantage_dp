<!-- Navigation Header Component -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top" style="background-color: rgba(255, 255, 255, 0.98); backdrop-filter: blur(10px); box-shadow: 0 2px 10px rgba(0,0,0,0.08);">
    <div class="container-fluid" style="max-width: 1400px; padding: 0.5rem 2rem;">
        <a class="navbar-brand d-flex align-items-center" href="/" style="margin-right: 2rem;">
            <img src="/image/Edvantage.png" alt="EDVANTAGE" style="height: 40px;">
        </a>
        
        <form class="d-none d-md-flex mx-3" action="{{ route('courses.search') }}" method="GET" style="flex: 1; max-width: 500px;">
            <input class="form-control" type="search" name="search" placeholder="What do you want to learn?" value="{{ request('search') }}" autocomplete="off" style="border-radius: 24px; padding: 0.5rem 1.25rem; border: 2px solid #e5e7eb;">
        </form>
        
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto d-lg-none mb-2">
                <li class="nav-item"><a class="nav-link fw-medium" href="#about">About Us</a></li>
                <li class="nav-item"><a class="nav-link fw-medium" href="#contact">Contact Us</a></li>
            </ul>
        </div>
        
        <div class="d-flex align-items-center gap-3 ms-auto">
            <a href="#about" class="text-decoration-none text-dark d-none d-lg-inline fw-medium" style="font-size: 0.9rem; transition: color 0.3s;">About Us</a>
            <a href="#contact" class="text-decoration-none text-dark d-none d-lg-inline fw-medium" style="font-size: 0.9rem; transition: color 0.3s;">Contact Us</a>
            
            <a href="/wishlist" class="btn btn-light d-flex align-items-center justify-content-center" title="Wishlist" style="width: 44px; height: 44px; border-radius: 50%; border: 1px solid #e5e7eb; transition: all 0.3s ease;">
                <i class="fa-solid fa-heart"></i>
            </a>
            
            <a href="/cart" class="btn btn-light d-flex align-items-center justify-content-center" title="Shopping Cart" style="width: 44px; height: 44px; border-radius: 50%; border: 1px solid #e5e7eb; transition: all 0.3s ease;">
                <i class="fa-solid fa-shopping-bag"></i>
            </a>
            
            <div class="dropdown">
                <button class="btn btn-dark d-flex align-items-center justify-content-center dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="width: 44px; height: 44px; border-radius: 50%; background: #0E1B33; border: none; transition: all 0.3s ease;">
                    <i class="fa-solid fa-user-circle" style="font-size: 1.1rem;"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0" style="min-width: 220px; border-radius: 12px; margin-top: 0.5rem;">
                    <li><a class="dropdown-item py-2 px-3" href="/profile" style="transition: all 0.2s; border-radius: 8px; margin: 0.25rem;"><i class="fa-solid fa-user me-2" style="width: 20px; color: #0E1B33;"></i> My Profile</a></li>
                    <li><a class="dropdown-item py-2 px-3" href="{{ route('courses.enrolled') }}" style="transition: all 0.2s; border-radius: 8px; margin: 0.25rem;"><i class="fa-solid fa-graduation-cap me-2" style="width: 20px; color: #0E1B33;"></i> My Courses</a></li>
                    <li><a class="dropdown-item py-2 px-3" href="{{ route('user.progress') }}" style="transition: all 0.2s; border-radius: 8px; margin: 0.25rem;"><i class="fa-solid fa-chart-line me-2" style="width: 20px; color: #0E1B33;"></i> My Progress</a></li>
                    <li><a class="dropdown-item py-2 px-3" href="/homepage" style="transition: all 0.2s; border-radius: 8px; margin: 0.25rem;"><i class="fa-solid fa-book-open me-2" style="width: 20px; color: #0E1B33;"></i> Course Catalog</a></li>
                    <li><a class="dropdown-item py-2 px-3" href="{{ route('purchase.history') }}" style="transition: all 0.2s; border-radius: 8px; margin: 0.25rem;"><i class="fa-solid fa-receipt me-2" style="width: 20px; color: #0E1B33;"></i> Purchase History</a></li>
                    <li><hr class="dropdown-divider my-2"></li>
                    <li><a class="dropdown-item py-2 px-3 text-danger" href="/logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="transition: all 0.2s; border-radius: 8px; margin: 0.25rem;"><i class="fa-solid fa-right-from-bracket me-2" style="width: 20px;"></i> Logout</a></li>
                </ul>
            </div>
            
            <span class="fw-semibold d-none d-lg-inline text-dark" style="font-size: 0.95rem; margin-left: 0.5rem;">{{ explode(' ', $user->name)[0] }}</span>
        </div>
        
        <form id="logout-form" action="/logout" method="POST" class="d-none">
            @csrf
        </form>
    </div>
</nav>