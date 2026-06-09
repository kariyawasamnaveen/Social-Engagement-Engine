<!-- MODERN ORDER RESUME WITH METALLIC DESIGN -->
<div class="col-lg-5 mb-4" id="order_resume" style="align-self: flex-start;">
    <div class="" style="padding: 24px; background: #0c0c0f !important; border: 3px solid transparent !important; background-image: linear-gradient(#0c0c0f, #0c0c0f), linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 50%, #475569 100%) !important; background-origin: border-box !important; background-clip: padding-box, border-box !important; border-radius: 24px !important; box-shadow: 0 15px 35px rgba(0,0,0,0.5) !important; backdrop-filter: blur(15px) !important;">
        
        <!-- Brushed Silver Header spanning full width of card -->
        <div class="pb-3 pt-3 px-3 border-bottom-0 mb-4" style="background: linear-gradient(90deg, #94a3b8 0%, #f1f5f9 50%, #cbd5e1 100%); border-radius: 20px 20px 0 0; margin: -24px -24px 20px -24px; box-shadow: inset 0 1px 0 rgba(255,255,255,0.8), 0 4px 15px rgba(0,0,0,0.15); display: flex; align-items: center; min-height: 70px;">
            <div class="d-flex align-items-center w-100">
                <div class="badge px-3 py-2 mr-3" style="background: #000; border: 1.5px solid #333; color: #00F0FF; border-radius: 8px; font-weight: 700; font-size: 11px;">
                    ID: <span class="service-id-val" style="color: #00F0FF;">-</span>
                </div>
                <h5 class="service-name text-dark mb-0" style="font-size: 14px; line-height: 1.4; font-weight: 800; font-family: 'Outfit', sans-serif; color: #0f172a !important;">Choose a service to view details</h5>
            </div>
        </div>

        <div class="p-0">
            <div class="row g-3">
                
                <!-- Rate per 1k -->
                <div class="col-12 mb-3">
                    <div class="p-3" style="background: #050507; border-radius: 14px; border: 1.5px solid rgba(255,255,255,0.06); box-shadow: inset 0 2px 4px rgba(0,0,0,0.5);">
                        <p class="text-muted mb-1" style="font-size: 10px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 700; color: #64748b !important;"><?= lang('rate_per_1000') ?></p>
                        <h4 class="text-white mb-0" style="font-weight: 800; font-size: 22px; color: #ffffff !important;">
                            <?=get_option('currency_symbol', '$')?><span class="service-price">0.00</span>
                        </h4>
                    </div>
                </div>
                
                <!-- Min / Max values side by side -->
                <div class="col-6 mb-3" style="padding-right: 7px;">
                    <div class="p-3 h-100" style="background: #050507; border-radius: 14px; border: 1.5px solid rgba(255,255,255,0.06); box-shadow: inset 0 2px 4px rgba(0,0,0,0.5);">
                        <p class="text-muted mb-1" style="font-size: 10px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 700; color: #64748b !important;"><?= lang('min') ?></p>
                        <p class="text-white mb-0 service-min-val" style="font-weight: 700; font-size: 15px; color: #ffffff !important;">-</p>
                    </div>
                </div>

                <div class="col-6 mb-3" style="padding-left: 7px;">
                    <div class="p-3 h-100" style="background: #050507; border-radius: 14px; border: 1.5px solid rgba(255,255,255,0.06); box-shadow: inset 0 2px 4px rgba(0,0,0,0.5);">
                        <p class="text-muted mb-1" style="font-size: 10px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 700; color: #64748b !important;"><?= lang('max') ?></p>
                        <p class="text-white mb-0 service-max-val" style="font-weight: 700; font-size: 15px; color: #ffffff !important;">-</p>
                    </div>
                </div>

                <!-- Average Delivery Time -->
                <?php if ((get_option("enable_average_time", 0) == 1)) : ?>
                <div class="col-12 mb-3">
                    <div class="d-flex align-items-center p-3" style="background: #050507; border-radius: 14px; border: 1.5px solid rgba(255,255,255,0.06); box-shadow: inset 0 2px 4px rgba(0,0,0,0.5); font-size: 12px;">
                        <svg class="mr-2" style="width: 14px; height: 14px; fill: #00F0FF;" viewBox="0 0 24 24"><path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/></svg>
                        <span style="font-weight: 600; color: #94a3b8;"><?= lang('Average_time') ?>: <span class="service-avg-time text-white ml-1" style="font-weight: 700; color: #ffffff !important;">-:-</span></span>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <!-- Service Details Description block -->
            <div class="description mt-4">
                <p class="text-muted mb-2" style="font-size: 10px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 700; color: #64748b !important;"><?=lang("Description")?></p>
                <div class="service-details p-3 text-muted" style="background: #050507; border-radius: 14px; border: 1.5px solid rgba(255,255,255,0.06); font-size: 13px; min-height: 150px; line-height: 1.6; max-height: 250px; overflow-y: auto; color: #94a3b8 !important; box-shadow: inset 0 2px 4px rgba(0,0,0,0.5);">
                    Select a service from the left options to view its detailed specifications and instructions.
                </div>
            </div>
        </div>
    </div>
</div>