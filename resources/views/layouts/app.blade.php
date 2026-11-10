<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $pageTitle ?? 'Dashboard' }} · CMNHousing BRM</title>
  <link rel="stylesheet" href="{{ asset('css/brm.css') }}">
  @stack('styles')
</head>
<body>
  <div class="app-shell">
    @include('layouts.sidebar')
    <div class="main">
      <header class="topbar">
        <div class="topbar-title">
          <button class="icon-btn" type="button" aria-label="Toggle sidebar">
            {!! \App\Support\Icon::svg('panelLeft') !!}
          </button>
          <div>
            <h1>{{ $pageTitle ?? 'Dashboard' }}</h1>
            <p>{{ $pageSub ?? 'CMNHousing · Builder Relationship Manager' }}</p>
          </div>
        </div>
        <div class="topbar-actions">
          <label class="search">
            {!! \App\Support\Icon::svg('search') !!}
            <input type="search" placeholder="Search builder, project, RERA, GST..." disabled>
          </label>
          <div class="qa-wrap">
            <button class="btn btn-primary qa-trigger" type="button" id="quickActionBtn" aria-expanded="false" aria-haspopup="true">
              {!! \App\Support\Icon::svg('plus') !!}
              Quick Action
            </button>
            <div class="qa-menu" id="quickActionMenu" hidden>
              @foreach (($quickActions ?? [
                'Add Builder','Add Project','Schedule Meeting','Upload Documents',
                'Approve Project','Upgrade Subscription','Generate Invoice','Export Report',
              ]) as $action)
                <button type="button">+ {{ $action }}</button>
              @endforeach
            </div>
          </div>
          <a class="icon-btn" href="{{ route('notifications.index') }}" aria-label="Notifications">
            {!! \App\Support\Icon::svg('bell') !!}
            <span class="badge-count">7</span>
          </a>
        </div>
      </header>
      <main class="content">
        @if (session('success'))
          <div class="card card-pad" style="margin-bottom:16px;color:#059669;">{{ session('success') }}</div>
        @endif
        @yield('content')
      </main>
    </div>
  </div>
  <script>
    (function () {
      const btn = document.getElementById('quickActionBtn');
      const menu = document.getElementById('quickActionMenu');
      if (!btn || !menu) return;
      btn.addEventListener('click', (e) => {
        e.stopPropagation();
        const open = menu.hasAttribute('hidden');
        if (open) {
          menu.removeAttribute('hidden');
          btn.setAttribute('aria-expanded', 'true');
        } else {
          menu.setAttribute('hidden', '');
          btn.setAttribute('aria-expanded', 'false');
        }
      });
      document.addEventListener('click', () => {
        menu.setAttribute('hidden', '');
        btn.setAttribute('aria-expanded', 'false');
      });
      menu.addEventListener('click', (e) => e.stopPropagation());
    })();
  </script>
  @stack('scripts')
</body>
</html>
