@php
  $active = $active ?? '';
  $workspace = [
    ['key' => 'dashboard', 'label' => 'Dashboard', 'route' => 'dashboard', 'icon' => 'grid'],
    ['key' => 'builders', 'label' => 'Builders', 'route' => 'builders.index', 'icon' => 'users'],
    ['key' => 'projects', 'label' => 'Projects', 'route' => 'projects.index', 'icon' => 'folder'],
    ['key' => 'builder-leads', 'label' => 'Leads', 'route' => 'builder-leads.index', 'icon' => 'userPlus'],
    ['key' => 'project-approvals', 'label' => 'Project Approvals', 'route' => 'project-approvals.index', 'icon' => 'clipboardCheck'],
    ['key' => 'subscriptions', 'label' => 'Subscriptions', 'route' => 'subscriptions.index', 'icon' => 'creditCard'],
    ['key' => 'site-visits', 'label' => 'Site Visits', 'route' => 'site-visits.index', 'icon' => 'mapPin'],
    ['key' => 'builder-support', 'label' => 'Builder Support', 'route' => 'builder-support.index', 'icon' => 'headset'],
    ['key' => 'payments', 'label' => 'Payments', 'route' => 'payments.index', 'icon' => 'wallet'],
    ['key' => 'documents', 'label' => 'Documents', 'route' => 'documents.index', 'icon' => 'file'],
  ];
  $insights = [
    ['key' => 'builder-performance', 'label' => 'Builder Performance', 'route' => 'builder-performance.index', 'icon' => 'trendingUp'],
    ['key' => 'analytics', 'label' => 'Analytics', 'route' => 'analytics.index', 'icon' => 'barChart'],
    ['key' => 'marketing', 'label' => 'Marketing', 'route' => 'marketing.index', 'icon' => 'megaphone'],
    ['key' => 'notifications', 'label' => 'Notifications', 'route' => 'notifications.index', 'icon' => 'bell'],
    ['key' => 'reports', 'label' => 'Reports', 'route' => 'reports.index', 'icon' => 'fileSearch'],
  ];
@endphp
<aside class="sidebar">
  <div class="brand">
    <div class="brand-mark">{!! \App\Support\Icon::svg('sparkles') !!}</div>
    <div>
      <strong>CMNHousing</strong>
      <span>Builder Relationship</span>
    </div>
  </div>

  <div class="nav-section">
    <div class="nav-label">Workspace</div>
    @foreach ($workspace as $item)
      <a href="{{ route($item['route']) }}" class="nav-link {{ $active === $item['key'] ? 'active' : '' }}">
        {!! \App\Support\Icon::svg($item['icon']) !!}
        {{ $item['label'] }}
      </a>
    @endforeach
  </div>

  <div class="nav-section">
    <div class="nav-label">Insights</div>
    @foreach ($insights as $item)
      <a href="{{ route($item['route']) }}" class="nav-link {{ $active === $item['key'] ? 'active' : '' }}">
        {!! \App\Support\Icon::svg($item['icon']) !!}
        {{ $item['label'] }}
      </a>
    @endforeach
  </div>

  <div class="sidebar-foot">
    <div class="avatar">
      @php
        $nameParts = preg_split('/\s+/', trim((string) (auth()->user()->name ?? 'Anita Rao'))) ?: ['A', 'R'];
        $initials = strtoupper(substr($nameParts[0] ?? 'A', 0, 1).substr($nameParts[1] ?? 'R', 0, 1));
      @endphp
      {{ $initials }}
    </div>
    <div style="flex:1;min-width:0;">
      <strong>{{ auth()->user()->name ?? 'Anita Rao' }}</strong>
      <span>Senior BRM</span>
    </div>
  </div>
</aside>
