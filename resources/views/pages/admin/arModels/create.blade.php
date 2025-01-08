@extends('layouts.app')

@section('content')
<div class="unMainContainer">
    <h1>Add Model</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('ar_models.store') }}" method="POST" enctype="multipart/form-data" class="p-4 border rounded">
        @csrf
        <div class="mb-3">
            <label for="gltf" class="form-label">GLTF File</label>
            <input type="file" name="gltf" accept=".gltf" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="bin" class="form-label">BIN File</label>
            <input type="file" name="bin" accept=".bin" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="textures" class="form-label">Texture Files (multiple)</label>
            <input type="file" name="textures[]" accept="image/*" class="form-control" multiple>
        </div>

        <button type="submit" class="btn btn-primary">Upload Model</button>
    </form>


</div>
@endsection
@section('scripts')
<!-- Include Three.js and OrbitControls -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.128/examples/js/controls/OrbitControls.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.128/examples/js/loaders/GLTFLoader.js"></script>

<div id="modelViewer" style="width: 100%; height: 600px;"></div>

<script>
    // Set up scene, camera, and renderer
    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
    const renderer = new THREE.WebGLRenderer();
    renderer.setSize(window.innerWidth, window.innerHeight);
    document.getElementById('modelViewer').appendChild(renderer.domElement);

    // Add lighting
    const light = new THREE.AmbientLight(0xffffff, 1); // Soft white light
    scene.add(light);

    // Load GLTF model
    const loader = new THREE.GLTFLoader();
    loader.load('/storage/path-to-your-uploaded-gltf-file.gltf', function (gltf) {
        scene.add(gltf.scene);
        gltf.scene.scale.set(1, 1, 1);  // Adjust the scale as needed
        renderer.render(scene, camera);
    }, undefined, function (error) {
        console.error('Error loading model:', error);
    });

    // Set up camera position
    camera.position.set(0, 1, 5);

    // Add OrbitControls for mouse interaction
    const controls = new THREE.OrbitControls(camera, renderer.domElement);
    controls.enableZoom = true; // Allow zooming with mouse wheel
    controls.update();

    // Animation loop
    function animate() {
        requestAnimationFrame(animate);
        controls.update();  // Update controls to handle interactions
        renderer.render(scene, camera);
    }
    animate();
    window.addEventListener('resize', () => {
    renderer.setSize(window.innerWidth, window.innerHeight);
    camera.aspect = window.innerWidth / window.innerHeight;
    camera.updateProjectionMatrix();
});

</script>

@endsection