<nav class="py-4">
    <div class="max-w-6xl mx-auto flex items-center justify-between">
        <a href="#" class="font-bold text-2xl text-white tracking-wide mb-2">
            ALVCA MATCHA
        </a>
        <ul class="flex space-x-6">
            <li><a href="/" class="font-medium hover:text-[#184d2e] transition-colors">Home</a></li>
            <li><a href="/products" class="font-medium hover:text-[#184d2e] transition-colors">Products</a></li>
            <li><a href="/about" class="font-medium hover:text-[#184d2e] transition-colors">About</a></li>
            <li><a href="/contact" class="font-medium hover:text-[#184d2e] transition-colors">Contact</a></li>

            <?php if(auth()->guard()->guest()): ?>
                
                <li><a href="<?php echo e(route('login')); ?>" class="font-medium hover:text-[#184d2e] transition-colors">Login</a></li>
            <?php endif; ?>

            <?php if(auth()->guard()->check()): ?>
                
                <li>
                    <form method="POST" action="<?php echo e(route('logout')); ?>">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="font-medium hover:text-[#184d2e] transition-colors">Logout</button>
                    </form>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>
<?php /**PATH /Users/jj/Herd/webdev_afl3-1/resources/views/includes/navigation.blade.php ENDPATH**/ ?>