<?php $__env->startSection('title', 'Profil Saya'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto py-10 px-4">

    
    <h1 class="text-3xl font-bold text-[#184d2e] mb-6">Profil Anda</h1>

    
    <?php if(session('success')): ?>
        <div class="bg-green-200 text-green-900 px-4 py-2 rounded mb-4">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="bg-red-200 text-red-900 px-4 py-2 rounded mb-4">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    
    <div class="bg-white shadow-md rounded-lg p-6 mb-8">
        <h2 class="text-xl font-semibold text-[#184d2e] mb-3">Informasi Akun</h2>

        <div class="space-y-2">
            <p><strong>Nama:</strong> <?php echo e($user->name); ?></p>
            <p><strong>Email:</strong> <?php echo e($user->email); ?></p>
            <p>
                <strong>Role:</strong> 
                <span class="px-3 py-1 rounded-full text-sm font-semibold <?php echo e($user->role === 'admin' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800'); ?>">
                    <?php echo e($user->role === 'admin' ? 'Admin' : 'User'); ?>

                </span>
            </p>
            <p><strong>Dibuat pada:</strong> <?php echo e($user->created_at->format('d M Y, H:i')); ?></p>
        </div>
    </div>

    
    <div class="bg-white shadow-md rounded-lg p-6 mb-8">
        <h2 class="text-xl font-semibold text-[#184d2e] mb-3">Ubah Username</h2>

        <form action="<?php echo e(route('user.updateName')); ?>" method="POST">
            <?php echo csrf_field(); ?>

            <label class="block font-medium mb-2">Nama Baru</label>
            <input type="text" name="name" value="<?php echo e($user->name); ?>"
                   class="w-full border rounded px-3 py-2 mb-4">

            <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                Simpan Perubahan
            </button>
        </form>
    </div>

    
    <div class="bg-white shadow-md rounded-lg p-6 mb-8">
        <h2 class="text-xl font-semibold text-[#184d2e] mb-3">Ubah Password</h2>

        <form action="<?php echo e(route('user.updatePassword')); ?>" method="POST">
            <?php echo csrf_field(); ?>

            <label class="block font-medium mb-2">Password Lama</label>
            <input type="password" name="current_password"
                   class="w-full border rounded px-3 py-2 mb-4">

            <label class="block font-medium mb-2">Password Baru</label>
            <input type="password" name="new_password"
                   class="w-full border rounded px-3 py-2 mb-4">

            <label class="block font-medium mb-2">Konfirmasi Password Baru</label>
            <input type="password" name="new_password_confirmation"
                   class="w-full border rounded px-3 py-2 mb-4">

            <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                Update Password
            </button>
        </form>
    </div>

    
    <div class="bg-red-100 shadow-md rounded-lg p-6">
        <h2 class="text-xl font-semibold text-red-700 mb-3">Hapus Akun</h2>

        <p class="mb-3">Aksi ini tidak dapat dibatalkan.</p>

        <form action="<?php echo e(route('user.destroy')); ?>" method="POST"
              onsubmit="return confirm('Yakin ingin menghapus akun?')">
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>

            <button class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                Hapus Akun
            </button>
        </form>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.mainlayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/jj/Herd/webdev_afl3-1/resources/views/profile.blade.php ENDPATH**/ ?>