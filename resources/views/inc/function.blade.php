{{-- Functions --}}
@php


if (!function_exists('setTitle')) :
    function setTitle($page_name) {

        // echo $page_name;

        $admin_name = '| CRM |';

        // Dashboard
        if ($page_name === 'sales') :
            echo 'Sales     ' . $admin_name;
        elseif ($page_name === 'analytics') :
            echo 'Analytics ' . $admin_name;

        // Production
        elseif ($page_name === 'reservation') :
            echo 'Reservation ' . $admin_name;
        elseif ($page_name === 'reservation_detail') :
            echo 'Reservation detail ' . $admin_name;
        elseif ($page_name === 'invoicing_sale') :
            echo 'Invoicing Sale ' . $admin_name;
        elseif ($page_name === 'invoicing_purchase') :
            echo 'Invoicing Purchase ' . $admin_name;

        // Bank
        elseif ($page_name === 'banks') :
            echo 'Bank Accounts';
        
        // Expense
        elseif ($page_name === 'expense') :
            echo 'Expense '. $admin_name;
        
        // Transaction
        elseif ($page_name === 'transaction') :
            echo 'Transaction '. $admin_name;
        
        // Contact
        elseif ($page_name === 'general_contact') :
            echo 'General Contact '. $admin_name;
        elseif ($page_name === 'sellers_contact') :
            echo 'Sellers Contact '. $admin_name;
        elseif ($page_name === 'buyers_contact') :
            echo 'Buyers Contacts '. $admin_name;
        
        // Mailbox
        elseif ($page_name === 'mailbox') :
            echo 'Mailbox '. $admin_name;
        
        // Admin
        elseif ($page_name === 'user_setup') :
            echo 'User Setup '. $admin_name;

            elseif ($page_name === 'company_setup') :
            echo 'Company Setup '. $admin_name;

            elseif ($page_name === 'agencys') :
            echo 'Agency List '. $admin_name;
            elseif ($page_name === 'hotel_list') :
            echo 'Hotel List '. $admin_name;
            elseif ($page_name === 'hotel_room_list') :
            echo 'Hotel Room List '. $admin_name;
            elseif ($page_name === 'rooms_list') :
            echo 'Rooms List '. $admin_name;
        
        
        endif;
    }
endif;

if (!function_exists('set_breadcrumb')) {
    function set_breadcrumb($page_name, $category_name) {
        
        $category = ucfirst($category_name);
        
        $removeUnderscore = str_replace('_', ' ', $page_name);

        $removeDash = str_replace('-', ' ', $removeUnderscore);

        $page = ucwords($removeDash);

        // Dashboard
        if ($page_name === 'analytics') :
            // echo 'CORK Admin - Multipurpose Bootstrap Dashboard Template';
            echo '<li class="breadcrumb-item"><a href="javascript:void(0);">'. $category .'</a></li>
                <li class="breadcrumb-item active" aria-current="page"><span>' . $page .'</span></li>';
        elseif ($page_name === 'sales') :
            // echo 'Sales Admin ' . $admin_name;
            echo '<li class="breadcrumb-item"><a href="javascript:void(0);">'. $category .'</a></li>
                <li class="breadcrumb-item active" aria-current="page"><span>' . $page .'</span></li>';

        // Production
        elseif ($page_name === 'reservation') :
            echo '<li class="breadcrumb-item"><a href="javascript:void(0);">'. $category .'</a></li>
                <li class="breadcrumb-item active" aria-current="page"><span>' . $page .'</span></li>';
        
        elseif ($page_name === 'reservation_detail') :
            echo '<li class="breadcrumb-item"><a href="javascript:void(0);">'. $category .'</a></li>
                <li class="breadcrumb-item active" aria-current="page"><span>' . $page .'</span></li>';

        elseif ($page_name === 'invoicing_sale') :
            echo '<li class="breadcrumb-item"><a href="javascript:void(0);">'. $category .'</a></li>
                <li class="breadcrumb-item active" aria-current="page"><span>Sale</span></li>';
        elseif ($page_name === 'invoicing_purchase') :
            echo '<li class="breadcrumb-item"><a href="javascript:void(0);">'. $category .'</a></li>
                <li class="breadcrumb-item active" aria-current="page"><span>Purchase</span></li>';

        // Bank
        // elseif ($page_name === 'banks') :
        //     echo '<li class="breadcrumb-item active" aria-current="page"><span>Bank Accounts</span></li>';

        // Expense
        // elseif ($page_name === 'expense') :
        //     echo '<li class="breadcrumb-item active" aria-current="page"><span>' . $page .'</span></li>';

        // Contact
        elseif ($page_name === 'general_contact') :
            echo '<li class="breadcrumb-item"><a href="javascript:void(0);">'. $category .'</a></li>
            <li class="breadcrumb-item active" aria-current="page"><span>' . $page .'</span></li>';
        elseif ($page_name === 'sellers_contact') :
            echo '<li class="breadcrumb-item"><a href="javascript:void(0);">'. $category .'</a></li>
            <li class="breadcrumb-item active" aria-current="page"><span>' . $page .'</span></li>';
        elseif ($page_name === 'buyers_contact') :
            echo '<li class="breadcrumb-item"><a href="javascript:void(0);">'. $category .'</a></li>
            <li class="breadcrumb-item active" aria-current="page"><span>' . $page .'</span></li>';

        // Mail
        elseif ($page_name === 'mailbox') :
            echo '<li class="breadcrumb-item active" aria-current="page"><span>' . $page .'</span></li>';
        
        // Admin
        elseif ($page_name === 'user_setup') :
            echo '<li class="breadcrumb-item"><a href="javascript:void(0);">'. $category .'</a></li>
            <li class="breadcrumb-item active" aria-current="page"><span>' . $page .'</span></li>';
        elseif ($page_name === 'company_setup') :
            echo '<li class="breadcrumb-item"><a href="javascript:void(0);">'. $category .'</a></li>
            <li class="breadcrumb-item active" aria-current="page"><span>' . $page .'</span></li>';

            elseif ($page_name === 'agencys') :
            echo '<li class="breadcrumb-item"><a href="javascript:void(0);">'. $category .'</a></li>
            <li class="breadcrumb-item active" aria-current="page"><span>' . $page .'</span></li>';

            elseif ($page_name === 'hotel_list') :
            echo '<li class="breadcrumb-item"><a href="javascript:void(0);">'. $category .'</a></li>
            <li class="breadcrumb-item active" aria-current="page"><span>' . $page .'</span></li>';


            elseif ($page_name === 'hotel_room_list') :
            echo '<li class="breadcrumb-item"><a href="javascript:void(0);">'. $category .'</a></li>
            <li class="breadcrumb-item active" aria-current="page"><span>' . $page .'</span></li>';


            elseif ($page_name === 'rooms_list') :
            echo '<li class="breadcrumb-item"><a href="javascript:void(0);">'. $category .'</a></li>
            <li class="breadcrumb-item active" aria-current="page"><span>' . $page .'</span></li>';


            elseif ($page_name === 'banks') :
            echo '<li class="breadcrumb-item"><a href="javascript:void(0);">'. $category .'</a></li>
            <li class="breadcrumb-item active" aria-current="page"><span>' . $page .'</span></li>';


            elseif ($page_name === 'transaction') :
            echo '<li class="breadcrumb-item"><a href="javascript:void(0);">'. $category .'</a></li>
            <li class="breadcrumb-item active" aria-current="page"><span>' . $page .'</span></li>';


            elseif ($page_name === 'expense') :
            echo '<li class="breadcrumb-item"><a href="javascript:void(0);">'. $category .'</a></li>
            <li class="breadcrumb-item active" aria-current="page"><span>' . $page .'</span></li>';


        endif;


    }
}


// Function to get the client IP address
// function get_client_ip() {
//     $ipaddress = '';
//     if (isset($_SERVER['HTTP_CLIENT_IP']))
//         $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
//     else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
//         $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
//     else if(isset($_SERVER['HTTP_X_FORWARDED']))
//         $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
//     else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
//         $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
//     else if(isset($_SERVER['HTTP_FORWARDED']))
//         $ipaddress = $_SERVER['HTTP_FORWARDED'];
//     else if(isset($_SERVER['REMOTE_ADDR']))
//         $ipaddress = $_SERVER['REMOTE_ADDR'];
//     else
//         $ipaddress = 'UNKNOWN';
//     return $ipaddress;
// }

// function scrollspy($offset) {
//     echo 'data-target="#navSection" data-spy="scroll" data-offset="'. $offset . '"';
// }

@endphp