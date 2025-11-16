<?php $__env->startSection('title', 'Keranjang - Alvca Matcha'); ?>

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
            <h1 class="text-4xl font-bold text-green-800 mb-3">Keranjang Saya</h1>
            <p class="text-gray-700 text-lg">
                Lihat dan kelola item yang ada di keranjang Anda.
            </p>
        </div>
    </section>

    
    <section class="my-8 py-6">
        <div class="max-w-6xl mx-auto px-4">
            <?php if($keranjang->count() > 0): ?>
                <div class="bg-white rounded-2xl shadow-md overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-green-600 text-white">
                                <tr>
                                    <th class="px-6 py-4 text-left font-semibold">Produk</th>
                                    <th class="px-6 py-4 text-center font-semibold">Harga Satuan</th>
                                    <th class="px-6 py-4 text-center font-semibold">Jumlah</th>
                                    <th class="px-6 py-4 text-center font-semibold">Total Harga</th>
                                    <th class="px-6 py-4 text-center font-semibold">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <?php
                                    $grandTotal = 0;
                                ?>
                                <?php $__currentLoopData = $keranjang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $grandTotal += $item->total_harga;
                                    ?>
                                    <tr class="hover:bg-green-50 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-4">
                                                <img src="<?php echo e(asset('images/' . $item->menu->gambar)); ?>" 
                                                     alt="<?php echo e($item->menu->nama); ?>"
                                                     class="w-20 h-20 object-cover rounded-lg shadow-sm">
                                                <div>
                                                    <h3 class="font-semibold text-green-800 text-lg"><?php echo e($item->menu->nama); ?></h3>
                                                    <p class="text-gray-600 text-sm"><?php echo e($item->menu->deskripsi); ?></p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="text-gray-700 font-medium">
                                                Rp <?php echo e(number_format($item->menu->harga ?? 0, 0, ',', '.')); ?>

                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <div class="flex items-center justify-center gap-2">
                                                
                                                <form action="<?php echo e(route('keranjang.update', $item->id)); ?>" method="POST" class="inline">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('PUT'); ?>
                                                    <input type="hidden" name="qty" value="<?php echo e(max(1, $item->qty - 1)); ?>">
                                                    <button type="submit" 
                                                            class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold w-10 h-10 rounded-lg transition-colors duration-200 flex items-center justify-center <?php echo e($item->qty <= 1 ? 'opacity-50 cursor-not-allowed' : ''); ?>"
                                                            <?php echo e($item->qty <= 1 ? 'disabled' : ''); ?>>
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                                
                                                
                                                <span class="w-16 text-center font-semibold text-lg text-gray-800">
                                                    <?php echo e($item->qty); ?>

                                                </span>
                                                
                                                
                                                <form action="<?php echo e(route('keranjang.update', $item->id)); ?>" method="POST" class="inline">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('PUT'); ?>
                                                    <input type="hidden" name="qty" value="<?php echo e($item->qty + 1); ?>">
                                                    <button type="submit" 
                                                            class="bg-green-500 hover:bg-green-600 text-white font-bold w-10 h-10 rounded-lg transition-colors duration-200 flex items-center justify-center">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="text-green-700 font-bold text-lg">
                                                Rp <?php echo e(number_format($item->total_harga, 0, ',', '.')); ?>

                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <form action="<?php echo e(route('keranjang.destroy', $item->id)); ?>" method="POST" class="inline">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" 
                                                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition-colors duration-200 font-medium"
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus item ini?')">
                                                    <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                            <tfoot class="bg-green-50">
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-right font-bold text-lg text-green-800">
                                        Total Keseluruhan:
                                    </td>
                                    <td colspan="2" class="px-6 py-4 text-center">
                                        <span class="text-green-700 font-bold text-2xl">
                                            Rp <?php echo e(number_format($grandTotal, 0, ',', '.')); ?>

                                        </span>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                
                <div class="mt-6 text-center">
                    <button class="bg-green-600 hover:bg-green-700 text-white font-bold px-8 py-3 rounded-full transition-colors duration-200 shadow-lg hover:shadow-xl text-lg">
                        Checkout
                    </button>
                </div>
            <?php else: ?>
                
                <div class="bg-white rounded-2xl shadow-md p-12 text-center">
                    <svg class="w-24 h-24 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <h2 class="text-2xl font-bold text-gray-700 mb-2">Keranjang Anda Kosong</h2>
                    <p class="text-gray-600 mb-6">Mulai berbelanja dan tambahkan produk ke keranjang Anda!</p>
                    <a href="<?php echo e(route('products')); ?>" class="inline-block bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-full transition-colors duration-200">
                        Lihat Produk
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </section>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.mainlayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/jj/Herd/webdev_afl3-1/resources/views/keranjang/keranjang.blade.php ENDPATH**/ ?>