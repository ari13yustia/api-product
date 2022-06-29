<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div wire:ignore id='map' style='width: 100%; height: 80vh;'></div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Form Input
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Longtitude</label>
                                <input wire:model="long" type="text" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Lattitude</label>
                                <input wire:model="lat" type="text" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:load', () => {
        mapboxgl.accessToken = 'pk.eyJ1IjoiYXJpMTN5dXN0aWFzIiwiYSI6ImNsNHh0ZjE3ODF0Z3QzY3Fuc2E4ZHVqZHkifQ.8FqjeEUNW_ih3GS2e4EyYQ';
            const map = new mapboxgl.Map({
            container: 'map', // container ID
            style: 'mapbox://styles/mapbox/streets-v11', // style URL
            center: [107.613144, -6.905977], // starting position [lng, lat]
            zoom: 9 // starting zoom
        });

        const el = document.createElement('div');
        el.className = 'marker';

        // make a marker for each feature and add to the map
        new mapboxgl.Marker(el).setLngLat([107.80759861354238,-6.953601806169829]).addTo(map);

        map.addControl(new mapboxgl.NavigationControl());

        map.on('click', (event) => {
            const longtitude = event.lngLat.lng;
            const lattitude = event.lngLat.lat;

            @this.long = longtitude;
            @this.lat = lattitude;
        });
    });
</script>
@endpush
