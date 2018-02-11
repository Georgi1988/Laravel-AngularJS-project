<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDealerDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dealer_details', function (Blueprint $table) {
            $table->increments('id');
            $table->string('shop_name');                                                    // 店面名称
            $table->string('shop_code');                                                    // 店面编号
            $table->string('dealer_name');                                                  // 所属客户名称
            $table->string('dealer_code');                                                  // 所属客户编号
            $table->string('dealer_kind');                                                  // 客户类别
            $table->string('upper_dealer_name');                                            // 所属客户上级客户名称
            $table->string('upper_dealer_code');                                            // 所属客户上级客户编号
            $table->string('area');                                                         // 区域
            $table->string('province');                                                     // 省份
            $table->string('city');                                                         // 城市
            $table->string('country_district');                                             // 店面所在县/区
            $table->string('city_level');                                                   // 城市级别
            $table->string('zone');                                                         // Zone
            $table->string('township');                                                     // 乡镇
            $table->string('area_boss_name');                                               // 区域经理
            $table->string('shop_dealer_name');                                             // 零售经理
            $table->string('city_boss_name');                                               // 城市经理
            $table->string('city_boss_code');                                               // 城市经理编号
            $table->string('cm_location');                                                  // CM_Location
            $table->string('business_kind');                                                // 业态类型
            $table->string('shop_kind');                                                    // 店类型
            $table->string('shop_short_kind');                                                  // 店类型-1
            $table->string('shop_property');                                                // 店面属性
            $table->string('shop_direction');                                               // 销售方向
            $table->string('total_area_of_shop');                                           // 店面总面积(平方米)
            $table->string('shop_monthly_sales');                                           // 店面月销售额(元)
            $table->string('shop_communication_address');                                   // 店面通信地址
            $table->string('shop_postal_code');                                             // 邮编
            $table->string('shop_phone_number');                                            // 店面电话
            $table->string('shop_boss_name');                                               // 店长姓名
            $table->string('shop_boss_phone_number');                                       // 店长电话
            $table->string('shop_boss_mobile_phone_number');                                // 店长手机
            $table->string('shop_boss_email');                                              // 店长邮箱地址
            $table->string('receipt_address');                                              // 授权牌收货地址
            $table->string('receipt_name')->nullable()->default(null);                      // 收货人姓名
            $table->string('receipt_phone_number')->nullable()->default(null);              // 收货人联系电话
            $table->string('receipt_mobile_phone_number')->nullable()->default(null);       // 收货人手机
            $table->string('cooperation_status');                                           // 合作状态
            $table->date('application_time');                                               // 申请时间
            $table->date('apply_for_approval_time');                                        // 申请审批时间
            $table->date('modify_approval_time');                                           // 修改审批时间
            $table->date('cancel_cooperation_approval_time')->nullable()->default(null);    // 取消合作审批时间
            $table->date('comment')->nullable()->default(null);                             // 备注
            $table->date('cooperation_kind');                                               // 合作类型
            $table->date('it_mall_whole_name');                                             // IT Mall全称
            $table->date('it_mall_short_name');                                             // IT Mall简称
            $table->date('location_kind');                                                  // 位置级别
            $table->date('area_of_dell');                                                   // Dell面积(平方米)
            $table->date('after_sales_service_point')->nullable()->default(null);           // 售后服务点
            $table->date('last_renovated_time')->nullable()->default(null);                 // 最后一次装修时间
            $table->string('dell_pay')->nullable()->default(null);                          // DELL付费
            $table->string('use_decoration_fund')->nullable()->default(null);               // 使用装修基金
            $table->integer('counter_number');                                              // 柜台数
            $table->integer('snp_cabinet_number');                                          // SNP柜数
            $table->integer('commitment_sales');                                            // 承诺销量(台数)
            $table->integer('shop_level');                                                  // 店面等级
            $table->boolean('nobody_shop');                                                 // 是否为无人门店
            $table->integer('platform_shop_rating')->nullable()->default(null);             // 平台店面评级
            $table->integer('registration_hours');                                          // 注册时间
            $table->integer('registration_approval_hours');                                 // 注册审批通过时间
            $table->string('line_under_report')->nullable()->default(null);                 // 线下报备
            $table->string('township_level');                                               // 乡镇级别(SIT)
            $table->string('shop_image_url')->nullable()->default(null);                    // 店面形象
            $table->string('process_status')->nullable()->default(null);                    // 流程状态
            $table->string('retail_manager_user_name');                                     // 零售经理用户名
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dealers_detail');
    }
}
