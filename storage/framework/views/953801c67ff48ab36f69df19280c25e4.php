

<?php $__env->startSection('title', 'Produk - Alvca Matcha'); ?>

<?php $__env->startSection('content'); ?>
    <section class="py-5 text-center bg-light border-bottom">
        <div class="container">
            <h1 class="fw-bold text-success mb-3">Produk Alvca Matcha</h1>
            <p class="text-muted mb-0">
                Temukan berbagai pilihan matcha terbaik — dari minuman segar hingga dessert premium.
            </p>
        </div>
    </section>

    <div class="container my-5">
        <?php $__currentLoopData = $menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="row align-items-center mb-5 py-4 <?php echo e($index % 2 == 0 ? 'bg-light rounded-4 shadow-sm' : ''); ?>">
                <div class="col-md-5 mb-3 mb-md-0">
                    <img src="<?php echo e(asset('images/' . $menu->gambar)); ?>" 
                         alt="<?php echo e($menu->nama); ?>"
                         class="img-fluid rounded-4 shadow-sm"
                         style="width: 100%; height: 300px; object-fit: cover;">
                </div>
                <div class="col-md-7">
                    <h2 class="fw-bold text-success mb-3"><?php echo e($menu->nama); ?></h2>
                    <p class="text-muted mb-4"><?php echo e($menu->deskripsi); ?></p>
                    <a href="#" class="btn btn-success px-4 py-2 rounded-pill">
                        <i class="bi bi-cart-plus me-2"></i> Tambah ke Keranjang
                    </a>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.mainlayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\jap_j\OneDrive\ドキュメント\vscode\webdev_afl3\resources\views/products.blade.php ENDPATH**/ ?>