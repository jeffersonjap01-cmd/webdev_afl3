<?php $__env->startSection('title', 'Keranjang - Alvca Matcha'); ?>

<?php $__env->startSection('content'); ?>
    
    <?php if(session('success')): ?>
        <div class="max-w-6xl mx-auto px-4 mt-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline"><?php echo e(session('success')); ?></span>
            </div>
        </div>
    <?php endif; ?>

    
    <?php if(isset($errors) && $errors->any()): ?>
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

    <?php if(session('error')): ?>
        <div class="max-w-6xl mx-auto px-4 mt-4">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <?php echo e(session('error')); ?>

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
                                    <th class="px-6 py-4 text-center font-semibold">Status</th>
                                    <th class="px-6 py-4 text-center font-semibold">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <?php
                                    $grandTotal = 0;
                                ?>
                                <?php $__currentLoopData = $keranjang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($item->status_pembayaran === 'Belum Bayar'): ?>
                                        <?php
                                            $grandTotal += $item->total_harga;
                                        ?>
                                    <?php endif; ?>
                                    <tr class="hover:bg-green-50 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-4">
                                                <img src="<?php echo e(asset('images/' . $item->menu->gambar)); ?>" 
                                                     alt="<?php echo e($item->menu->nama); ?>"
                                                     class="w-20 h-20 object-cover rounded-lg shadow-sm">
                                                <div>
                                                    <h3 class="font-semibold text-green-800 text-lg"><?php echo e($item->menu->nama); ?></h3>
                                                    <p class="text-gray-600 text-sm"><?php echo e($item->menu->deskripsi); ?></p>
                                                    <?php if($item->lokasiToko): ?>
                                                        <p class="text-blue-600 text-xs mt-1">
                                                            <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                            </svg>
                                                            <?php echo e($item->lokasiToko->nama_lokasi); ?>

                                                        </p>
                                                    <?php endif; ?>
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
                                                <?php if($item->status_pembayaran === 'Belum Bayar'): ?>
                                                    
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
                                                <?php else: ?>
                                                    <button type="button"
                                                            class="bg-gray-100 text-gray-400 font-bold w-10 h-10 rounded-lg cursor-not-allowed"
                                                            disabled>
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                                        </svg>
                                                    </button>
                                                <?php endif; ?>
                                                
                                                
                                                <span class="w-16 text-center font-semibold text-lg text-gray-800">
                                                    <?php echo e($item->qty); ?>

                                                </span>
                                                
                                                <?php if($item->status_pembayaran === 'Belum Bayar'): ?>
                                                    
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
                                                <?php else: ?>
                                                    <button type="button"
                                                            class="bg-gray-100 text-gray-400 font-bold w-10 h-10 rounded-lg cursor-not-allowed"
                                                            disabled>
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                        </svg>
                                                    </button>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="text-green-700 font-bold text-lg">
                                                Rp <?php echo e(number_format($item->total_harga, 0, ',', '.')); ?>

                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="px-3 py-1 rounded-full text-sm font-semibold <?php echo e($item->status_pembayaran === 'Dibayar' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'); ?>">
                                                <?php echo e($item->status_pembayaran ?? 'Belum Bayar'); ?>

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
                                    <td colspan="4" class="px-6 py-4 text-right font-bold text-lg text-green-800">
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

                
                <?php if($keranjang->where('status_pembayaran', 'Belum Bayar')->count() > 0): ?>
                <?php
                    $activeOrderType = old('order_type', $defaultOrderType);
                    $firstItem = $keranjang->first();
                    $existingLokasiId = $firstItem->lokasi_toko_id ?? null;
                    $existingAlamat = $firstItem->alamat ?? null;
                    $existingMejaId = $firstItem->meja_id ?? null;
                    $prefilledDeliveryLokasi = old('delivery_lokasi_toko_id', $activeOrderType === 'delivery' ? $existingLokasiId : null);
                    $prefilledDineInLokasi = old('dine_in_lokasi_toko_id', $activeOrderType === 'dine_in' ? $existingLokasiId : null);
                    $prefilledMejaId = old('meja_id', $activeOrderType === 'dine_in' ? $existingMejaId : null);
                ?>
                <div class="mt-6 bg-white rounded-2xl shadow-md p-8">
                    <h2 class="text-2xl font-bold text-green-800 mb-6">Pembayaran</h2>
                    
                    
                    <div class="mb-6">
                        <p class="text-gray-700 font-medium mb-2">Pilih Metode Pemenuhan Pesanan</p>
                        <div class="flex gap-4">
                            <button type="button"
                                    class="order-type-tab flex-1 px-4 py-3 rounded-lg border text-center font-semibold transition-colors <?php echo e($activeOrderType === 'delivery' ? 'bg-green-600 text-white border-green-600' : 'bg-white text-gray-700 border-gray-300'); ?>"
                                    data-order-type="delivery">
                                Delivery
                            </button>
                            <button type="button"
                                    class="order-type-tab flex-1 px-4 py-3 rounded-lg border text-center font-semibold transition-colors <?php echo e($activeOrderType === 'dine_in' ? 'bg-green-600 text-white border-green-600' : 'bg-white text-gray-700 border-gray-300'); ?>"
                                    data-order-type="dine_in">
                                Dine In
                            </button>
                        </div>
                        <?php $__errorArgs = ['order_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-600 text-sm mt-2"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    
                    <div class="mb-6">
                        <label class="block text-gray-700 font-medium mb-2">Kode Promo (Opsional)</label>
                        <form action="<?php echo e(route('promo.apply')); ?>" method="POST" class="flex gap-2">
                            <?php echo csrf_field(); ?>
                            <input type="text" 
                                   name="kode_promo" 
                                   placeholder="Masukkan kode promo"
                                   class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                            <button type="submit" 
                                    class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg transition-colors">
                                Terapkan
                            </button>
                        </form>
                        <?php if($promoApplied): ?>
                            <div class="mt-2 bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded flex items-center justify-between">
                                <span>Promo diterapkan: <?php echo e($promoApplied->nama_promo); ?></span>
                                <?php if($promoDiscount > 0): ?>
                                    <span class="font-semibold">- Rp <?php echo e(number_format($promoDiscount, 0, ',', '.')); ?></span>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    
                    <div id="deliveryFormWrapper" class="<?php echo e($activeOrderType === 'delivery' ? '' : 'hidden'); ?>">
                        <form action="<?php echo e(route('payment.cart')); ?>" method="POST" enctype="multipart/form-data" class="space-y-5">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="order_type" value="delivery">
                            <?php if($promoApplied): ?>
                                <input type="hidden" name="promo_id" value="<?php echo e($promoApplied->id); ?>">
                            <?php endif; ?>

                            <div>
                                <label class="block text-gray-700 font-medium mb-2">Pilih Cabang Pengiriman</label>
                                <select name="delivery_lokasi_toko_id"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                                    <option value="">-- Pilih Lokasi --</option>
                                    <?php $__currentLoopData = $lokasiTokos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lokasi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($lokasi->id); ?>" <?php echo e($prefilledDeliveryLokasi == $lokasi->id ? 'selected' : ''); ?>>
                                            <?php echo e($lokasi->nama_lokasi); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['delivery_lokasi_toko_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="text-red-600 text-sm mt-2"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div>
                                <label class="block text-gray-700 font-medium mb-2">Alamat Pengiriman</label>
                                <textarea name="delivery_alamat_lengkap"
                                          rows="3"
                                          placeholder="Masukkan alamat lengkap pengiriman"
                                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"><?php echo e(old('delivery_alamat_lengkap', $activeOrderType === 'delivery' ? ($existingAlamat->alamat_lengkap ?? '') : '')); ?></textarea>
                                <?php $__errorArgs = ['delivery_alamat_lengkap'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="text-red-600 text-sm mt-2"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <div class="mt-3 grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <input type="text"
                                           name="delivery_kota"
                                           placeholder="Kota"
                                           value="<?php echo e(old('delivery_kota', $activeOrderType === 'delivery' ? ($existingAlamat->kota ?? '') : '')); ?>"
                                           class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                                    <input type="text"
                                           name="delivery_provinsi"
                                           placeholder="Provinsi"
                                           value="<?php echo e(old('delivery_provinsi', $activeOrderType === 'delivery' ? ($existingAlamat->provinsi ?? '') : '')); ?>"
                                           class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                                </div>
                                <input type="text"
                                       name="delivery_kode_pos"
                                       placeholder="Kode Pos (Opsional)"
                                       value="<?php echo e(old('delivery_kode_pos', $activeOrderType === 'delivery' ? ($existingAlamat->kode_pos ?? '') : '')); ?>"
                                       class="mt-3 w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                                <input type="text"
                                       name="delivery_no_telepon"
                                       placeholder="No. Telepon (Opsional)"
                                       value="<?php echo e(old('delivery_no_telepon', $activeOrderType === 'delivery' ? ($existingAlamat->no_telepon ?? '') : '')); ?>"
                                       class="mt-3 w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                                <?php $__errorArgs = ['delivery_kota'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="text-red-600 text-sm mt-2"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <?php $__errorArgs = ['delivery_provinsi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="text-red-600 text-sm mt-2"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div>
                                <label class="block text-gray-700 font-medium mb-2">Metode Pembayaran</label>
                                <select name="metode_pembayaran" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                                    <option value="tunai">Tunai</option>
                                    <option value="debit">Debit</option>
                                    <option value="kredit">Kredit</option>
                                    <option value="e_wallet">E-Wallet</option>
                                    <option value="qris">QRIS</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-gray-700 font-medium mb-2">Bukti Pembayaran <span class="text-red-500">*</span></label>
                                <input type="file" 
                                       name="bukti_pembayaran" 
                                       accept="image/*"
                                       required
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                            </div>

                            <div>
                                <label class="block text-gray-700 font-medium mb-2">Catatan (Opsional)</label>
                                <textarea name="catatan" 
                                          rows="3"
                                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"><?php echo e(old('catatan')); ?></textarea>
                            </div>

                            <div class="p-4 bg-green-50 rounded-lg space-y-2">
                                <div class="flex justify-between text-sm text-gray-600">
                                    <span>Subtotal</span>
                                    <span>Rp <?php echo e(number_format($grandTotal, 0, ',', '.')); ?></span>
                                </div>
                                <?php if($promoDiscount > 0): ?>
                                    <div class="flex justify-between text-sm text-green-700">
                                        <span>Diskon <?php echo e($promoApplied->nama_promo ?? ''); ?></span>
                                        <span>- Rp <?php echo e(number_format($promoDiscount, 0, ',', '.')); ?></span>
                                    </div>
                                <?php endif; ?>
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-semibold text-green-800">Total Pembayaran:</span>
                                    <span class="text-2xl font-bold text-green-700">
                                        Rp <?php echo e(number_format($payableTotal, 0, ',', '.')); ?>

                                    </span>
                                </div>
                            </div>

                            <button type="submit" 
                                    class="w-full bg-green-600 hover:bg-green-700 text-white font-bold px-8 py-3 rounded-lg transition-colors duration-200 shadow-lg hover:shadow-xl text-lg">
                                Bayar Delivery
                            </button>
                        </form>
                    </div>

                    <div id="dineInFormWrapper" class="<?php echo e($activeOrderType === 'dine_in' ? '' : 'hidden'); ?>">
                        <form action="<?php echo e(route('payment.cart')); ?>" method="POST" enctype="multipart/form-data" class="space-y-5">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="order_type" value="dine_in">
                            <?php if($promoApplied): ?>
                                <input type="hidden" name="promo_id" value="<?php echo e($promoApplied->id); ?>">
                            <?php endif; ?>

                            <input type="hidden" name="dine_in_lokasi_toko_id" id="dineInLokasiInput" value="<?php echo e($prefilledDineInLokasi); ?>">

                            <div>
                                <label class="block text-gray-700 font-medium mb-2">Pilih Cabang Dine In</label>
                                <div class="flex flex-wrap gap-3" id="dineInLocationButtons">
                                    <?php $__empty_1 = true; $__currentLoopData = $lokasiTokos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lokasi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <button type="button"
                                                data-dine-in-location="<?php echo e($lokasi->id); ?>"
                                                class="dine-in-location-btn flex-1 min-w-[200px] px-4 py-3 rounded-xl border text-left transition-all <?php echo e($prefilledDineInLokasi == $lokasi->id ? 'bg-green-600 text-white border-green-600 shadow-lg' : 'bg-white text-gray-700 border-gray-300 hover:border-green-500 hover:shadow'); ?>">
                                            <span class="block font-semibold text-base"><?php echo e($lokasi->nama_lokasi); ?></span>
                                            <span class="block text-xs <?php echo e($prefilledDineInLokasi == $lokasi->id ? 'text-green-50' : 'text-gray-500'); ?>">
                                                <?php echo e($lokasi->alamat ?? 'Alamat belum tersedia'); ?>

                                            </span>
                                        </button>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <p class="text-sm text-gray-500">Belum ada cabang dine-in yang tersedia.</p>
                                    <?php endif; ?>
                                </div>
                                <?php $__errorArgs = ['dine_in_lokasi_toko_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="text-red-600 text-sm mt-2"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="space-y-4" id="dineInTablesWrapper">
                                <div id="dineInPlaceholder" class="rounded-xl border border-dashed border-gray-300 bg-gray-50 px-4 py-3 text-sm text-gray-600 <?php echo e($prefilledDineInLokasi ? 'hidden' : ''); ?>">
                                    Pilih cabang terlebih dahulu untuk melihat daftar meja yang tersedia.
                                </div>

                                <?php $__currentLoopData = $lokasiTokos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lokasi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="dine-in-table-group rounded-2xl border border-gray-200 p-5 <?php echo e($prefilledDineInLokasi == $lokasi->id ? '' : 'hidden'); ?>"
                                         data-dine-in-table-group="<?php echo e($lokasi->id); ?>">
                                        <div class="flex justify-between items-center mb-4">
                                            <div>
                                                <p class="text-sm text-gray-500">Meja tersedia di</p>
                                                <h4 class="text-lg font-semibold text-green-800"><?php echo e($lokasi->nama_lokasi); ?></h4>
                                            </div>
                                            <span class="text-xs px-3 py-1 rounded-full bg-green-100 text-green-700">
                                                <?php echo e($lokasi->mejas->count()); ?> meja
                                            </span>
                                        </div>

                                        <?php if($lokasi->mejas->count() > 0): ?>
                                            <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                                <?php $__currentLoopData = $lokasi->mejas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $meja): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div>
                                                        <input type="radio"
                                                               name="meja_id"
                                                               value="<?php echo e($meja->id); ?>"
                                                               id="meja_option_<?php echo e($meja->id); ?>"
                                                               class="hidden peer dine-in-table-radio"
                                                               data-lokasi="<?php echo e($lokasi->id); ?>"
                                                               <?php echo e($prefilledMejaId == $meja->id ? 'checked' : ''); ?>>
                                                        <label for="meja_option_<?php echo e($meja->id); ?>"
                                                               class="block rounded-xl border border-gray-200 px-4 py-3 cursor-pointer transition-all hover:border-green-500 hover:shadow peer-checked:border-green-600 peer-checked:bg-green-50 peer-checked:shadow-lg"
                                                               data-lokasi="<?php echo e($lokasi->id); ?>">
                                                            <span class="block text-base font-semibold text-gray-800">Meja <?php echo e($meja->nomor_meja); ?></span>
                                                            <span class="text-xs text-gray-500 peer-checked:text-green-700">Klik untuk memilih</span>
                                                        </label>
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        <?php else: ?>
                                            <p class="text-sm text-gray-500">Belum ada meja yang tersedia untuk cabang ini.</p>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <?php $__errorArgs = ['meja_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-red-600 text-sm mt-2"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <?php if($lokasiTokos->flatMap->mejas->isEmpty()): ?>
                                <p class="text-yellow-700 text-sm mt-2">Belum ada meja yang tersedia untuk dine in.</p>
                            <?php endif; ?>

                            <div>
                                <label class="block text-gray-700 font-medium mb-2">Metode Pembayaran</label>
                                <select name="metode_pembayaran" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                                    <option value="tunai">Tunai</option>
                                    <option value="debit">Debit</option>
                                    <option value="kredit">Kredit</option>
                                    <option value="e_wallet">E-Wallet</option>
                                    <option value="qris">QRIS</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-gray-700 font-medium mb-2">Bukti Pembayaran <span class="text-red-500">*</span></label>
                                <input type="file" 
                                       name="bukti_pembayaran" 
                                       accept="image/*"
                                       required
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                            </div>

                            <div>
                                <label class="block text-gray-700 font-medium mb-2">Catatan (Opsional)</label>
                                <textarea name="catatan" 
                                          rows="3"
                                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"><?php echo e(old('catatan')); ?></textarea>
                            </div>

                            <div class="p-4 bg-green-50 rounded-lg space-y-2">
                                <div class="flex justify-between text-sm text-gray-600">
                                    <span>Subtotal</span>
                                    <span>Rp <?php echo e(number_format($grandTotal, 0, ',', '.')); ?></span>
                                </div>
                                <?php if($promoDiscount > 0): ?>
                                    <div class="flex justify-between text-sm text-green-700">
                                        <span>Diskon <?php echo e($promoApplied->nama_promo ?? ''); ?></span>
                                        <span>- Rp <?php echo e(number_format($promoDiscount, 0, ',', '.')); ?></span>
                                    </div>
                                <?php endif; ?>
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-semibold text-green-800">Total Pembayaran:</span>
                                    <span class="text-2xl font-bold text-green-700">
                                        Rp <?php echo e(number_format($payableTotal, 0, ',', '.')); ?>

                                    </span>
                                </div>
                            </div>

                            <button type="submit" 
                                    class="w-full bg-green-600 hover:bg-green-700 text-white font-bold px-8 py-3 rounded-lg transition-colors duration-200 shadow-lg hover:shadow-xl text-lg">
                                Bayar Dine In
                            </button>
                        </form>
                    </div>

                </div>
                <?php endif; ?>
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tabs = document.querySelectorAll('.order-type-tab');
            const formWrappers = {
                delivery: document.getElementById('deliveryFormWrapper'),
                dine_in: document.getElementById('dineInFormWrapper'),
            };
            let activeOrderType = <?php echo json_encode($activeOrderType ?? 'delivery', 15, 512) ?> || 'delivery';

            const setOrderType = (type) => {
                activeOrderType = type;
                tabs.forEach((tab) => {
                    const isActive = tab.dataset.orderType === type;
                    tab.classList.toggle('bg-green-600', isActive);
                    tab.classList.toggle('text-white', isActive);
                    tab.classList.toggle('border-green-600', isActive);
                    tab.classList.toggle('bg-white', !isActive);
                    tab.classList.toggle('text-gray-700', !isActive);
                    tab.classList.toggle('border-gray-300', !isActive);
                });

                Object.entries(formWrappers).forEach(([key, wrapper]) => {
                    if (!wrapper) return;
                    wrapper.classList.toggle('hidden', key !== type);
                });
            };

            tabs.forEach((tab) => {
                tab.addEventListener('click', () => setOrderType(tab.dataset.orderType));
            });
            setOrderType(activeOrderType);

            const dineInLocationInput = document.getElementById('dineInLokasiInput');
            const dineInLocationButtons = document.querySelectorAll('.dine-in-location-btn');
            const dineInTableGroups = document.querySelectorAll('.dine-in-table-group');
            const dineInPlaceholder = document.getElementById('dineInPlaceholder');
            const dineInTableRadios = document.querySelectorAll('.dine-in-table-radio');

            const setActiveDineInLocation = (lokasiId) => {
                dineInLocationButtons.forEach((button) => {
                    const isActive = button.dataset.dineInLocation === lokasiId;
                    button.classList.toggle('bg-green-600', isActive);
                    button.classList.toggle('text-white', isActive);
                    button.classList.toggle('border-green-600', isActive);
                    button.classList.toggle('shadow-lg', isActive);
                    button.classList.toggle('text-gray-700', !isActive);
                    button.classList.toggle('border-gray-300', !isActive);
                    button.classList.toggle('bg-white', !isActive);
                    button.classList.toggle('hover:border-green-500', !isActive);
                });

                dineInTableGroups.forEach((group) => {
                    const isMatch = lokasiId && group.dataset.dineInTableGroup === lokasiId;
                    group.classList.toggle('hidden', !isMatch);
                });

                dineInTableRadios.forEach((radio) => {
                    const isMatch = lokasiId && radio.dataset.lokasi === lokasiId;
                    radio.disabled = !isMatch;
                    if (!isMatch && radio.checked) {
                        radio.checked = false;
                    }
                });

                if (dineInPlaceholder) {
                    dineInPlaceholder.classList.toggle('hidden', Boolean(lokasiId));
                }
            };

            dineInLocationButtons.forEach((button) => {
                button.addEventListener('click', () => {
                    const lokasiId = button.dataset.dineInLocation;
                    if (dineInLocationInput) {
                        dineInLocationInput.value = lokasiId;
                    }
                    setOrderType('dine_in');
                    setActiveDineInLocation(lokasiId);
                });
            });

            const initialLocation = dineInLocationInput ? dineInLocationInput.value : '';
            if (initialLocation) {
                setActiveDineInLocation(initialLocation);
            } else {
                setActiveDineInLocation('');
            }

            dineInTableRadios.forEach((radio) => {
                radio.addEventListener('change', () => setOrderType('dine_in'));
            });
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.mainlayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/jj/Herd/webdev_afl3-1/resources/views/keranjang/keranjang.blade.php ENDPATH**/ ?>