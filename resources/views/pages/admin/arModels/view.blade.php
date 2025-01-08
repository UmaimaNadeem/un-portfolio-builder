@extends('layouts.app')

@section('content')
<div class="unMainContainer">
    <h1>AR Model: {{ $armodel->id }}</h1>

    <div class="card">
        <div class="card-body">
            
            @if ($armodel->gltf)
            <div id="arModelViewer" style="width: 100%; height: 400px;"></div>

                <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/three/examples/js/loaders/GLTFLoader.js"></script>
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        const scene = new THREE.Scene();
                        const camera = new THREE.PerspectiveCamera(75, window.innerWidth / 400, 0.1, 1000);
                        const renderer = new THREE.WebGLRenderer({ antialias: true });
                        renderer.setSize(window.innerWidth, 400);
                        document.getElementById('arModelViewer').appendChild(renderer.domElement);

                        // Set up lighting
                        const light = new THREE.AmbientLight(0x404040, 2); // Ambient light with intensity
                        scene.add(light);

                        const directionalLight = new THREE.DirectionalLight(0xffffff, 1); // Directional light
                        directionalLight.position.set(5, 5, 5).normalize();
                        scene.add(directionalLight);

                        // Load the GLTF model
                        const loader = new THREE.GLTFLoader();
                        loader.load('{{ url($armodel->gltf) }}', function(gltf) {
                            scene.add(gltf.scene);
                            gltf.scene.scale.set(1, 1, 1); // Adjust the size of the model
                            camera.position.set(0, 1, 5); // Adjust the camera position

                            // Render the scene
                            const animate = function () {
                                requestAnimationFrame(animate);
                                renderer.render(scene, camera);
                            };
                            animate();
                        }, undefined, function(error) {
                            console.error('Error loading the GLTF model:', error);
                        });
                    });
                </script>

            @else
                <p>No AR model available for this project.</p>
            @endif

            <form action="{{ route('armodels.destroy', $armodel->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </div>
    </div>
</div>
@endsection
