<?php
return [
    '401_title' => 'الاذن مرفوض',
    '401_msg'   => '<li>لم يتم منحك حق الوصول إلى القسم من قبل المسؤول.</li>
	                <li>قد يكون لديك نوع حساب خاطئ.</li>
	                <li>أنت غير مصرح لك لعرض الموارد المطلوبة.</li>
	                <li>Your subscription may have expired.</li>',
    '404_title' => 'Page could not be found',
    '404_msg'   => '<li>The page you requested does not exist.</li>
	                <li>The link you clicked is no longer.</li>
	                <li>The page may have moved to a new location.</li>
	                <li>An error may have occurred.</li>
	                <li>You are not authorized to view the requested resource.</li>',
    '500_title' => 'Page could not be loaded',
    '500_msg'   => '<li>The page you requested does not exist.</li>
	                <li>The link you clicked is no longer.</li>
	                <li>The page may have moved to a new location.</li>
	                <li>An error may have occurred.</li>
	                <li>You are not authorized to view the requested resource.</li>',
    'reasons'   => 'This may have occurred because of several reasons',
    'try_again' => 'Please try again in a few minutes, or alternatively return to the homepage by <a href="' . route('dashboard.index') . '">clicking here</a>.',
];
