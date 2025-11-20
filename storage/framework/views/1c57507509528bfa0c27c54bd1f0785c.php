<?php $__env->startSection('title', 'Produk - Alvca Matcha'); ?>

<?php $__env->startSection('content'); ?>
    
    <?php if(session('success')): ?>
        <div class="max-w-6xl mx-auto px-4 mt-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline"><?php echo e(session('success')); ?></span>
            </div>
        </div>
    <?php endif; ?>

    
    <?php if($errors->any()): ?>
        <div class="max-w-6xl mx-auto px-4 mt-4">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <ul class="list-disc list-inside">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        </div>
    <?php endif; ?>

    
    <section class="py-8 text-center bg-gradient-to-b from-green-50 to-green-100 border-b border-green-200">
        <div class="max-w-6xl mx-auto px-4">
            <h1 class="text-4xl font-bold text-green-800 mb-3">Produk Alvca Matcha</h1>
            <p class="text-gray-700 text-lg">
                Temukan berbagai pilihan matcha terbaik — dari minuman segar hingga dessert premium.
            </p>
        </div>
    </section>

    
    <section class="my-8 py-6">
        <div class="max-w-6xl mx-auto px-4">
            <?php $__currentLoopData = $menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="mb-8 py-6 <?php echo e($index % 2 == 0 ? 'bg-white rounded-2xl shadow-md' : 'bg-green-50 rounded-2xl shadow-sm'); ?>">
                    <div class="flex flex-col md:flex-row items-center gap-6 px-6">
                        
                        <div class="w-full md:w-2/5">
                            <img src="<?php echo e(asset('images/' . $menu->gambar)); ?>" 
                                 alt="<?php echo e($menu->nama); ?>"
                                 class="w-full h-64 md:h-80 object-cover rounded-xl shadow-lg">
                        </div>
                        
                        
                        <div class="w-full md:w-3/5 text-center md:text-left">
                            <h2 class="text-3xl font-bold text-green-800 mb-3"><?php echo e($menu->nama); ?></h2>
                            <p class="text-gray-700 mb-4 leading-relaxed"><?php echo e($menu->deskripsi); ?></p>
                            
                            <p class="text-2xl font-semibold text-green-700 mb-4">
                                Rp <?php echo e(number_format($menu->harga ?? 0, 0, ',', '.')); ?>

                            </p>

                            
                            <div class="mb-4">
                                <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold <?php echo e(($menu->stok ?? 0) > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                                    Stok: <?php echo e($menu->stok ?? 0); ?>

                                </span>
                            </div>

                            
                            <?php if(auth()->guard()->check()): ?>
                                <?php if(($menu->stok ?? 0) <= 0): ?>
                                    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                                        <p class="text-red-800 font-semibold">
                                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                            </svg>
                                            Produk ini sedang habis stok.
                                        </p>
                                    </div>
                                <?php else: ?>
                                <div class="space-y-4">
                                    <div class="flex items-center gap-2 mb-3">
                                        <label for="qty_<?php echo e($menu->id); ?>" class="text-gray-700 font-medium">Jumlah:</label>
                                        <input type="number" 
                                               id="qty_<?php echo e($menu->id); ?>" 
                                               name="qty_<?php echo e($menu->id); ?>"
                                               value="1" 
                                               min="1" 
                                               class="w-20 px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                                    </div>

                                    
                                    <form action="<?php echo e(route('keranjang.store')); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="menu_id" value="<?php echo e($menu->id); ?>">
                                        <input type="hidden" name="qty" id="qty_cart_<?php echo e($menu->id); ?>" value="1">
                                        
                                        <button type="submit" 
                                                onclick="document.getElementById('qty_cart_<?php echo e($menu->id); ?>').value = document.getElementById('qty_<?php echo e($menu->id); ?>').value"
                                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-full transition-colors duration-200 shadow-md hover:shadow-lg">
                                            <span class="flex items-center justify-center gap-2">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                                </svg>
                                                Tambah ke Keranjang
                                            </span>
                                        </button>
                                        <p class="text-xs text-gray-500 mt-2">
                                            Pilih metode pengambilan dan detail lokasi di halaman keranjang.
                                        </p>
                                    </form>
                                </div>
                                <?php endif; ?>
                            <?php else: ?>
                                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                    <p class="text-yellow-800 mb-2">
                                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                        </svg>
                                        Silakan <a href="<?php echo e(route('login')); ?>" class="text-green-600 hover:text-green-700 font-semibold underline">login</a> untuk menambahkan produk ke keranjang.
                                    </p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.mainlayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/jj/Herd/webdev_afl3-1/resources/views/products.blade.php ENDPATH**/ ?>