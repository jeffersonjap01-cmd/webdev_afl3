<?php $__env->startSection('title', 'Register'); ?>

<?php $__env->startSection('content'); ?>

<div class="flex justify-center mt-16 mb-20">
    <div class="bg-white shadow-xl rounded-xl p-10 w-full max-w-md border-t-4 border-[#184d2e]">

        <h2 class="text-3xl font-bold text-center text-[#184d2e] mb-6">
            Create Your Account
        </h2>

        
        <?php if($errors->any()): ?>
            <div class="mb-4 bg-red-100 text-red-700 p-3 rounded">
                <ul class="list-disc px-5">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo e(route('register')); ?>">
            <?php echo csrf_field(); ?>

            
            <div class="mb-4">
                <label class="block mb-1 font-medium">Full Name</label>
                <input type="text" name="name" required autofocus
                       class="w-full border rounded-lg px-4 py-2 focus:ring-[#184d2e] focus:border-[#184d2e]"
                       value="<?php echo e(old('name')); ?>">
            </div>

            
            <div class="mb-4">
                <label class="block mb-1 font-medium">Email</label>
                <input type="email" name="email" required
                       class="w-full border rounded-lg px-4 py-2 focus:ring-[#184d2e] focus:border-[#184d2e]"
                       value="<?php echo e(old('email')); ?>">
            </div>

            
            <div class="mb-4">
                <label class="block mb-1 font-medium">Password</label>
                <input type="password" name="password" required
                       class="w-full border rounded-lg px-4 py-2 focus:ring-[#184d2e] focus:border-[#184d2e]">
            </div>

            
            <div class="mb-6">
                <label class="block mb-1 font-medium">Confirm Password</label>
                <input type="password" name="password_confirmation" required
                       class="w-full border rounded-lg px-4 py-2 focus:ring-[#184d2e] focus:border-[#184d2e]">
            </div>

            
            <button class="w-full bg-[#184d2e] hover:bg-[#21633a] text-white font-semibold py-2 rounded-lg transition">
                Create Account
            </button>
        </form>

        <div class="text-center mt-6">
            <p class="text-sm">
                Already have an account?
                <a href="<?php echo e(route('login')); ?>" class="text-[#184d2e] font-semibold hover:underline">
                    Login here
                </a>
            </p>
        </div>

    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.mainlayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/jj/Herd/webdev_afl3-1/resources/views/auth/register.blade.php ENDPATH**/ ?>