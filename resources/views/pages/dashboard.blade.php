<div class="dashboard-section">
    <div class="head-intro">
        <h1>Hi, <?php echo $data["fullname"]; ?> <span>👋</span></h1>
    </div>
    <div class="sec-title">
        <div class="pull-left">
            <h4>Instructor Dashboard</h4>
        </div>
        <div class="pull-right">
            <span class="see-all add-new-course">Tạo khóa học mới</span>
        </div>
    </div>
    <!-- end sectitle -->
    <div class="row">

        <!-- Dashboard Block -->
        <div class="dashboard-block">
            <div class="inner-box">
                <div class="content">
                    <div class="icon-box">
                        <i class="far fa-newspaper"></i>
                    </div>
                    <div class="courses">Tất cả khóa học<span><?php echo $data["totalCourse"]; ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dashboard Block -->
        <div class="dashboard-block">
            <div class="inner-box">
                <div class="content">
                    <div class="icon-box">
                        <i class="fas fa-laptop-code"></i>
                    </div>
                    <div class="courses">Số học viên
                        <span> <?php echo $data["numberStudent"]; ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dashboard Block -->
        <div class="dashboard-block">
            <div class="inner-box">
                <div class="content">
                    <div class="icon-box">
                        <i class="fas fa-hand-holding-usd"></i>
                    </div>

                    <div class="courses">Tổng doanh thu
                        <span> $<?php echo $data["totalSales"]; ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dashboard Block -->
        <!-- <div class="dashboard-block">
            <div class="inner-box">
                <div class="content">
                    <div class="icon-box">
                        <i class="fas fa-money-check-alt"></i>
                    </div>
                    <div class="courses">Account Balance<span>$2.5k</span></div>
                </div>
            </div>
        </div> -->

    </div>
    <!-- end row -->
</div>
<!-- end dashboard -->