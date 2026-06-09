<div class="row justify-content-center">
    <div class="col-md-10 col-xl-9">
        <!-- Support Header Banner -->
        <div class="page-header d-flex align-items-center justify-content-between mb-4 mt-2 p-4" style="background: rgba(20, 20, 24, 0.4); border: 1px solid var(--border-dim); border-radius: 24px; backdrop-filter: blur(15px);">
            <div class="d-flex align-items-center">
                <span class="d-flex align-items-center justify-content-center mr-3" style="width: 44px; height: 44px; background: rgba(255, 0, 127, 0.08); border: 1px solid rgba(255, 0, 127, 0.2); border-radius: 12px; color: var(--accent-pink); box-shadow: 0 4px 15px rgba(255, 0, 127, 0.1);">
                    <i class="fe fe-message-circle" style="font-size: 20px;"></i>
                </span>
                <div>
                    <h1 class="page-title mb-1" style="font-size: 20px; font-weight: 700; color: #fff;">
                        <?=lang("Tickets")?>
                    </h1>
                    <p class="text-muted mb-0" style="font-size: 13px;">Need assistance? Open a ticket below</p>
                </div>
            </div>
            <a href="<?=cn($controller_name . "/add")?>" class="btn btn-primary d-none d-sm-flex align-items-center btn-pill px-4 py-2" style="font-size: 13px; font-weight: 700; box-shadow: 0 4px 15px rgba(255, 0, 127, 0.2);">
                <i class="fe fe-plus mr-2" style="font-size: 14px;"></i> <?=lang("add_new")?>
            </a>
        </div>

        <!-- Search Bar -->
        <div class="form-group mb-4">
            <div class="input-group search-area" style="background: rgba(19, 19, 21, 0.5); border-radius: 14px; border: 1px solid var(--border-dim); overflow: hidden; height: 52px; align-items: center;">
                <span class="input-group-text bg-transparent border-0 pl-3 pr-2">
                    <i class="fe fe-search text-muted" style="font-size: 16px;"></i>
                </span>
                <input type="text" name="query" class="form-control bg-transparent border-0 text-white" placeholder="<?=lang('Search_for_')?>" style="box-shadow: none; font-size: 14px; padding-left: 5px;">
            </div>
        </div>

        <!-- Ticket Lists Loop -->
        <?php if(!empty($items)): ?>
            <div class="ticket-lists">
                <?php foreach ($items as $key => $item): 
                    $this->load->view('child/index', ['controller_name' => $controller_name, 'item' => $item]);
                endforeach; ?>
            </div>
            
            <div class="mt-4">
                <?php echo show_pagination($pagination); ?>
            </div>
        <?php else: ?>
            <div class="card p-5 text-center" style="background: rgba(20, 20, 24, 0.4); border: 1px solid var(--border-dim); border-radius: 24px; backdrop-filter: blur(15px);">
                <div class="mb-3 d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px; background: rgba(255,255,255,0.02); border-radius: 50%; border: 1px solid var(--border-dim);">
                    <i class="fe fe-message-square text-muted" style="font-size: 32px;"></i>
                </div>
                <h4 class="text-white font-weight-bold mb-2"><?=lang('no_tickets_found')?></h4>
                <p class="text-muted mb-4" style="max-width: 400px; margin: 0 auto 24px auto;"><?=lang('if_you_have_any_questions_please_open_a_new_ticket')?></p>
                <a href="<?=cn($controller_name . "/add")?>" class="btn btn-primary btn-pill px-5 py-3" style="font-size: 14px; font-weight: 700; box-shadow: 0 4px 15px rgba(255, 0, 127, 0.2);">
                    <?=lang("add_new_ticket")?>
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Floating Action Button for Mobile screens -->
<a href="<?=cn($controller_name . "/add")?>" class="btn btn-primary btn-add-ticket-floating d-flex d-sm-none align-items-center justify-content-center">
    <i class="fe fe-plus" style="font-size: 24px;"></i>
</a>
