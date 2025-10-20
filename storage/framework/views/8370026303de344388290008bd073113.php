

<?php $__env->startSection('title', 'Beranda - Matcha Website'); ?>

<?php $__env->startSection('content'); ?>
    
    <section class="hero" 
        style="background-image: linear-gradient(rgba(0,0,0,0.35), rgba(0,0,0,0.35)), url('<?php echo e(asset('images/matcha_header.jpg')); ?>');">
        <div class="container px-3 text-center">
            <h1>Welcome to <span class="text-success">Alvca Matcha</span></h1>
            <p>Discover the fresh, authentic taste of matcha with our handcrafted drinks and treats.</p>
        </div>
    </section>

    
    <div class="container my-5 py-4">
        <div class="row g-4">
            <?php $__currentLoopData = $menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="menu col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <img src="<?php echo e(asset('images/' . $menu->gambar)); ?>" 
                             alt="<?php echo e($menu->nama); ?>"
                             class="card-img-top"
                             style="height: 250px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title fw-bold"><?php echo e($menu->nama); ?></h5>
                            <p class="card-text"><?php echo e($menu->deskripsi); ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.mainlayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/jj/Herd/afl2/resources/views/home.blade.php ENDPATH**/ ?>