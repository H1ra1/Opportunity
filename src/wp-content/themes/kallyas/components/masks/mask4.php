<?php if(! defined('ABSPATH')){ return; }

$alignment = '';

if ( $mask == 'mask4 mask4l' ) {
    $alignment = 'svgmask-left';
}
elseif ( $mask == 'mask4 mask4r' ) {
    $alignment = 'svgmask-right';
}
?>

<svg width="5000px" height="27px" class="svgmask <?php echo esc_attr( $alignment ); ?>" viewBox="0 0 5000 27" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
    <defs>
        <filter x="-50%" y="-50%" width="200%" height="200%" filterUnits="objectBoundingBox" id="filter-mask4">
            <feOffset dx="0" dy="2" in="SourceAlpha" result="shadowOffsetInner1"></feOffset>
            <feGaussianBlur stdDeviation="1.5" in="shadowOffsetInner1" result="shadowBlurInner1"></feGaussianBlur>
            <feComposite in="shadowBlurInner1" in2="SourceAlpha" operator="arithmetic" k2="-1" k3="1" result="shadowInnerInner1"></feComposite>
            <feColorMatrix values="0 0 0 0 0   0 0 0 0 0   0 0 0 0 0  0 0 0 0.35 0" in="shadowInnerInner1" type="matrix" result="shadowMatrixInner1"></feColorMatrix>
            <feMerge>
                <feMergeNode in="SourceGraphic"></feMergeNode>
                <feMergeNode in="shadowMatrixInner1"></feMergeNode>
            </feMerge>
        </filter>
    </defs>
    <path d="M3.63975516e-12,-0.007 L2418,-0.007 L2434,-0.007 C2434,-0.007 2441.89,0.742 2448,2.976 C2454.11,5.21 2479,15 2479,15 L2492,21 C2492,21 2495.121,23.038 2500,23 C2505.267,23.03 2508,21 2508,21 L2521,15 C2521,15 2545.89,5.21 2552,2.976 C2558.11,0.742 2566,-0.007 2566,-0.007 L2582,-0.007 L5000,-0.007 L5000,27 L2500,27 L3.63975516e-12,27 L3.63975516e-12,-0.007 Z" class="bmask-bgfill" filter="url(#filter-mask4)" fill="#f5f5f5"  style="fill:<?php echo esc_attr( $bgcolor ); ?>"></path>
</svg>
