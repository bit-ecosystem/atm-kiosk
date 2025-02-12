<?php

namespace App\Enums;

enum PageCategoryEnum: string
{
    case sss = 'Staff Self Service';
    case pc = 'Payroll and Compensation';
    case la = 'Leave and Attendance';
    case be = 'Benefits and Entitlements';
    case pm = 'Performance Management';
    case cc = 'Communication and Collaboration';
    case em = 'Expense Management';
    case oo = 'Onboarding and Offboarding';
    case sa = 'Self-Service Analytics';
    case sh = 'Support and Helpdesk';
    case op = 'Operations';
    case sp = 'Support';
    case lm = 'Learning';
    case kb = 'Knowledge Base';
    case ip = 'Ideas';

}
