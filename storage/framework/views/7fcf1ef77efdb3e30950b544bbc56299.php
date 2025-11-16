<?php $__env->startSection('title', 'Admin - Kelola Produk'); ?>

<?php $__env->startSection('content'); ?>
    
    <?php if(session('success')): ?>
        <div class="max-w-6xl mx-auto px-4 mt-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline"><?php echo e(session('success')); ?></span>
            </div>
        </div>
    <?php endif; ?>

    
    <section class="py-8 text-center bg-gradient-to-b from-green-50 to-green-100 border-b border-green-200">
        <div class="max-w-6xl mx-auto px-4">
            <h1 class="text-4xl font-bold text-green-800 mb-3">Kelola Produk</h1>
            <p class="text-gray-700 text-lg">
                Tambah, edit, atau hapus produk dari katalog.
            </p>
        </div>
    </section>

    
    <section class="my-8 py-6">
        <div class="max-w-6xl mx-auto px-4">
            <div class="mb-6 flex justify-between items-center">
                <h2 class="text-2xl font-bold text-green-800">Daftar Produk</h2>
                <a href="<?php echo e(route('admin.products.create')); ?>" 
                   class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Produk Baru
                </a>
            </div>

            <?php if($menus->count() > 0): ?>
                <div class="bg-white rounded-2xl shadow-md overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-green-600 text-white">
                                <tr>
                                    <th class="px-6 py-4 text-left font-semibold">Gambar</th>
                                    <th class="px-6 py-4 text-left font-semibold">Nama</th>
                                    <th class="px-6 py-4 text-left font-semibold">Deskripsi</th>
                                    <th class="px-6 py-4 text-center font-semibold">Harga</th>
                                    <th class="px-6 py-4 text-center font-semibold">Stok</th>
                                    <th class="px-6 py-4 text-center font-semibold">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <?php $__currentLoopData = $menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="hover:bg-green-50 transition-colors">
                                        <td class="px-6 py-4">
                                            <img src="<?php echo e(asset('images/' . $menu->gambar)); ?>" 
                                                 alt="<?php echo e($menu->nama); ?>"
                                                 class="w-20 h-20 object-cover rounded-lg shadow-sm">
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="font-semibold text-green-800"><?php echo e($menu->nama); ?></span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <p class="text-gray-700 text-sm line-clamp-2"><?php echo e($menu->deskripsi); ?></p>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="text-green-700 font-semibold">
                                                Rp <?php echo e(number_format($menu->harga, 0, ',', '.')); ?>

                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <form action="<?php echo e(route('admin.products.updateStock', $menu->id)); ?>" method="POST" class="inline-flex items-center gap-2">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PUT'); ?>
                                                <input type="number" 
                                                       name="stok" 
                                                       value="<?php echo e($menu->stok ?? 0); ?>" 
                                                       min="0"
                                                       class="w-20 px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-center">
                                                <button type="submit" 
                                                        class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition-colors duration-200 font-medium">
                                                    Update
                                                </button>
                                            </form>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <div class="flex items-center justify-center gap-2">
                                                <a href="<?php echo e(route('admin.products.edit', $menu->id)); ?>" 
                                                   class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition-colors duration-200 font-medium">
                                                    Edit
                                                </a>
                                                <form action="<?php echo e(route('admin.products.destroy', $menu->id)); ?>" 
                                                      method="POST" 
                                                      class="inline"
                                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" 
                                                            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition-colors duration-200 font-medium">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php else: ?>
                <div class="bg-white rounded-2xl shadow-md p-12 text-center">
                    <svg class="w-24 h-24 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    <h2 class="text-2xl font-bold text-gray-700 mb-2">Belum Ada Produk</h2>
                    <p class="text-gray-600 mb-6">Mulai dengan menambahkan produk pertama Anda!</p>
                    <a href="<?php echo e(route('admin.products.create')); ?>" 
                       class="inline-block bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-full transition-colors duration-200">
                        Tambah Produk
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </section>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.mainlayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/jj/Herd/webdev_afl3-1/resources/views/admin/products/index.blade.php ENDPATH**/ ?>