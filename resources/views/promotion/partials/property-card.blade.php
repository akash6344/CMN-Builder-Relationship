<div class="promotion-property-card">
    <img src="{{ $property['images'][0] }}" alt="{{ $property['title'] }}">
    <div class="body">
        <h3>{{ $property['title'] }}</h3>
        <p class="loc">{{ $property['locality'] }}, {{ $property['city'] }}</p>
        <p class="price">{{ $property['price'] }}</p>
        <p class="loc">{{ $property['beds'] }} BHK · {{ $property['baths'] }} Bath · {{ $property['area'] }}</p>
    </div>
</div>
