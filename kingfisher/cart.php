<?php 
require_once 'config.php';
include_once 'header.php';

// Mô phỏng sản phẩm trong giỏ hàng để kiểm thử chức năng
$sample_product_name = "Cần câu Shimano Poison Adrena High-end";
$sample_price = 8500000;
$shipping_fee = 50000;
$pvc_tube_fee = 35000; // Phí bảo vệ đóng ống cứng PVC
?>

<div class="container mx-auto px-4 py-10 max-w-4xl">
    <h2 class="text-2xl font-black text-gray-800 mb-6 tracking-tight">🛒 GIỎ HÀNG & THỦ TỤC THANH TOÁN</h2>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Danh sách sản phẩm chọn đặt -->
        <div class="lg:col-span-2 space-y-4">
            <div class="bg-white p-4 rounded-lg border shadow-sm flex gap-4 items-center">
                <img src="https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=150" class="w-16 h-16 object-cover rounded bg-gray-100">
                <div class="flex-1 text-xs">
                    <h3 class="font-bold text-sm text-gray-900"><?php echo $sample_product_name; ?></h3>
                    <p class="text-gray-400 mt-0.5">Thương hiệu: Shimano Japan</p>
                    <div class="font-bold text-[#0A2540] mt-2 text-sm"><?php echo number_format($sample_price, 0, ',', '.'); ?> đ</div>
                </div>
                <div class="text-xs font-bold text-gray-500 px-3 py-1 bg-gray-100 rounded">SL: 1</div>
            </div>

            <!-- Tùy chọn bảo vệ cấu hình hàng cồng kềnh -->
            <div class="bg-orange-50 border border-orange-200 rounded-lg p-4 text-xs">
                <div class="flex items-start gap-3">
                    <input type="checkbox" id="pvc-opt" checked class="w-4 h-4 mt-0.5 accent-orange-600">
                    <div>
                        <label for="pvc-opt" class="font-bold text-orange-950 block cursor-pointer text-sm">Đóng gói bằng ống nhựa PVC bảo vệ chuyên dụng (+35.000đ)</label>
                        <span class="text-orange-800 font-light mt-1 block leading-relaxed">Khuyên dùng cho sản phẩm cần câu cá thuôn dài. Lõi cần thủ sẽ được luồn trong ống nhựa PVC cứng chịu lực, chống gãy nát dập khoen tuyệt đối 100% trong suốt lộ trình bưu cục giao hàng xa.</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cột tóm tắt thanh toán biên nhận đơn hàng -->
        <div class="bg-white p-6 rounded-lg border shadow-sm h-fit space-y-4 text-xs font-medium">
            <h3 class="text-sm font-bold border-b pb-2 text-gray-800">TÓM TẮT ĐƠN HÀNG</h3>
            <div class="flex justify-between">
                <span class="text-gray-500">Tiền hàng:</span>
                <span class="font-bold"><?php echo number_format($sample_price, 0, ',', '.'); ?> đ</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Phí giao hàng:</span>
                <span class="font-bold"><?php echo number_format($shipping_fee, 0, ',', '.'); ?> đ</span>
            </div>
            <div class="flex justify-between text-orange-700">
                <span>Phí đóng ống PVC:</span>
                <span class="font-bold">+<?php echo number_format($pvc_tube_fee, 0, ',', '.'); ?> đ</span>
            </div>
            <hr>
            <div class="flex justify-between text-sm font-black text-gray-900">
                <span>Tổng chi phí:</span>
                <span class="text-[#0A2540]"><?php echo number_format(($sample_price + $shipping_fee + $pvc_tube_fee), 0, ',', '.'); ?> đ</span>
            </div>

            <?php if(isset($_SESSION['user_id'])): ?>
                <button onclick="alert('🎉 Đặt đơn thành công! Hệ thống KingFisher đang tiến hành đóng gói PVC cho thiết bị của bạn.')" class="w-full bg-[#0A2540] hover:bg-slate-800 text-white font-bold py-3 rounded uppercase tracking-wider text-center mt-2 block">Xác Nhận Đặt Hàng</button>
            <?php else: ?>
                <a href="login.php" class="w-full bg-amber-500 hover:bg-amber-600 text-black font-bold py-3 rounded uppercase tracking-wider text-center mt-2 block">Đăng nhập để đặt hàng</a>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include_once 'footer.php'; ?>