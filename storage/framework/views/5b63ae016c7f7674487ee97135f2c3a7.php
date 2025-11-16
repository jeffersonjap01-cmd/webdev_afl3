<?php $__env->startSection('title', 'Login'); ?>

<?php $__env->startSection('content'); ?>

<div class="flex justify-center mt-16 mb-20">
    <div class="bg-white shadow-xl rounded-xl p-10 w-full max-w-md border-t-4 border-[#184d2e]">

        <h2 class="text-3xl font-bold text-center text-[#184d2e] mb-6">
            Login to Your Account
        </h2>

        
        <?php if(session('status')): ?>
            <div class="mb-4 text-green-700 bg-green-100 p-2 rounded">
                <?php echo e(session('status')); ?>

            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo e(route('login')); ?>">
            <?php echo csrf_field(); ?>

            
            <div class="mb-4">
                <label class="block mb-1 font-medium">Email</label>
                <input type="email" name="email" required autofocus
                       class="w-full border rounded-lg px-4 py-2 focus:ring-[#184d2e] focus:border-[#184d2e]">
            </div>

            
            <div class="mb-4">
                <label class="block mb-1 font-medium">Password</label>
                <input type="password" name="password" required
                       class="w-full border rounded-lg px-4 py-2 focus:ring-[#184d2e] focus:border-[#184d2e]">
            </div>

            
            <div class="flex items-center mb-4">
                <input id="remember_me" type="checkbox" name="remember"
                       class="rounded focus:ring-[#184d2e] text-[#184d2e]">
                <label for="remember_me" class="ms-2 text-sm">Remember me</label>
            </div>

            
            <button class="w-full bg-[#184d2e] hover:bg-[#21633a] text-white font-semibold py-2 rounded-lg transition">
                Login
            </button>
        </form>

        <div class="text-center mt-6">
            <p class="text-sm">
                Don't have an account? 
                <a href="<?php echo e(route('register')); ?>" class="text-[#184d2e] font-semibold hover:underline">
                    Register here
                </a>
            </p>
        </div>

    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.mainlayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/jj/Herd/webdev_afl3-1/resources/views/auth/login.blade.php ENDPATH**/ ?>