<?php
    $item_link_detail = cn($controller_name ."/" . $item['id']);
    $item_status = $item['status'];
    $status_title = ticket_status_title($item['status']);
    
    // Status color presets
    $status_bg = 'rgba(139, 92, 246, 0.12)'; // Purple default (Pending)
    $status_color = '#8B5CF6';
    
    if (strtolower($item_status) == 'answered' || strtolower($item_status) == 'completed') {
        $status_bg = 'rgba(0, 240, 255, 0.12)'; // Cyan (Answered)
        $status_color = '#00F0FF';
    } elseif (strtolower($item_status) == 'closed') {
        $status_bg = 'rgba(255, 255, 255, 0.05)'; // Gray (Closed)
        $status_color = '#9CA3AF';
    }
    
    $changed_date = convert_timezone($item['changed'], 'user');
?>

<div class="ticket-item-card mb-3" style="overflow: hidden; border: 1px solid var(--border-dim); border-radius: 18px; background: rgba(20, 20, 24, 0.6); transition: all 0.3s ease;">
    <a href="<?=$item_link_detail?>" class="p-4 d-flex align-items-center text-decoration-none w-100 h-100" style="gap: 15px;">
        <!-- Left Side: Chat Icon -->
        <div class="ticket-icon-badge" style="width: 48px; height: 48px; min-width: 48px; background: rgba(255, 255, 255, 0.02); border-radius: 12px; display: flex; align-items: center; justify-content: center; border: 1px solid var(--border-dim); color: <?=$status_color?>;">
            <i class="fe fe-message-square" style="font-size: 18px;"></i>
        </div>
        
        <!-- Right Side: Details -->
        <div class="w-100">
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-2 gap-2">
                <h5 class="subject mb-0 text-white" style="font-size: 15px; font-weight: 600;">
                    #<?=$item['id']?> - <?=esc($item['subject'])?>
                    <?php if ($item['user_read']): ?>
                        <span class="badge" style="font-size: 9px; padding: 2px 6px; background: rgba(251, 191, 36, 0.15); border: 1px solid rgba(251, 191, 36, 0.3); color: #FBBF24; border-radius: 4px; font-weight: 700; margin-left: 6px;"><?=lang("Unread")?></span>
                    <?php endif; ?>
                </h5>
                <span class="badge px-3 py-1" style="background: <?=$status_bg?>; border: 1px solid <?=rgba_color($status_color, 0.2)?>; color: <?=$status_color?>; font-size: 11px; font-weight: 700; border-radius: 8px;">
                    <?=$status_title?>
                </span>
            </div>
            
            <div class="d-flex justify-content-between align-items-center mt-1">
                <span class="time text-muted" style="font-size: 12px; font-weight: 500;">
                    <i class="fe fe-clock mr-1" style="font-size: 11px;"></i> <?=date("M d, H:i", strtotime($changed_date))?>
                </span>
                <span class="text-primary font-weight-bold d-flex align-items-center" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; gap: 4px;">
                    <?=lang('View')?> <i class="fe fe-chevron-right" style="font-size: 12px;"></i>
                </span>
            </div>
        </div>
    </a>
</div>

<?php
if (!function_exists('rgba_color')) {
    function rgba_color($hex, $alpha) {
        $hex = str_replace('#', '', $hex);
        if(strlen($hex) == 3) {
            $r = hexdec(substr($hex,0,1).substr($hex,0,1));
            $g = hexdec(substr($hex,1,1).substr($hex,1,1));
            $b = hexdec(substr($hex,2,1).substr($hex,2,1));
        } else {
            $r = hexdec(substr($hex,0,2));
            $g = hexdec(substr($hex,2,2));
            $b = hexdec(substr($hex,4,2));
        }
        return "rgba($r, $g, $b, $alpha)";
    }
}
?>