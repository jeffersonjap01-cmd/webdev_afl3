<?php $__env->startSection('title', 'Beranda - Matcha Website'); ?>

<?php $__env->startSection('content'); ?>
    
    <section class="hero" 
        style="background-image: linear-gradient(rgba(0,0,0,0.35), rgba(0,0,0,0.35)), url('<?php echo e(asset('images/matcha_header.jpg')); ?>');">
        <div class="max-w-6xl mx-auto text-center px-4">
            <h1>Welcome to <span>Alvca Matcha</span></h1>
            <p>Discover the fresh, authentic taste of matcha with our handcrafted drinks and treats.</p>
            <button class="btn-hero mt-4">Shop Now</button>
        </div>
    </section>

    
    <section class="my-5 py-4 matcha-section">
        <div class="max-w-6xl mx-auto text-center px-4">
            <h2 class="section-title">Our Products</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php $__currentLoopData = $menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="product-card bg-white rounded-xl overflow-hidden shadow-sm transition-transform duration-300">
                        <img src="<?php echo e(asset('images/' . $menu->gambar)); ?>" 
                             alt="<?php echo e($menu->nama); ?>" 
                             class="w-full h-64 object-cover">
                        <div class="p-4 text-left">
                            <h5 class="text-lg font-semibold mb-2"><?php echo e($menu->nama); ?></h5>
                            <p class="text-gray-700 text-sm mb-2"><?php echo e($menu->deskripsi); ?></p>
                            <p class="text-green-700 font-bold text-lg">
                                Rp <?php echo e(number_format($menu->harga ?? 0, 0, ',', '.')); ?>

                            </p>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.mainlayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/jj/Herd/webdev_afl3-1/resources/views/home.blade.php ENDPATH**/ ?>