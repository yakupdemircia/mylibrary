<table border="0" cellpadding="5" cellspacing="0" style="border:1px solid">
    <tr>
        <td colspan="3" style="border-bottom:1px solid #ccc"><strong>Contact Form:</strong></td>
    </tr>
    <tr>
        <td style="border-bottom:1px solid #ccc">Name</td>
        <td style="border-bottom:1px solid #ccc">:</td>
        <td style="border-bottom:1px solid #ccc">{{ $r['cf_name'] ?? '' }}</td>
    </tr>
    <tr>
        <td style="border-bottom:1px solid #ccc">Email</td>
        <td style="border-bottom:1px solid #ccc">:</td>
        <td style="border-bottom:1px solid #ccc">{{ $r['cf_email'] ?? '' }}</td>
    </tr>
    <tr>
        <td style="border-bottom:1px solid #ccc">Subject</td>
        <td style="border-bottom:1px solid #ccc">:</td>
        <td style="border-bottom:1px solid #ccc">{{ $r['cf_subject'] ?? '' }}</td>
    </tr>
    <tr>
        <td style="border-bottom:1px solid #ccc">Message</td>
        <td style="border-bottom:1px solid #ccc">:</td>
        <td style="border-bottom:1px solid #ccc">{!! $r['cf_message'] ?? ''  !!}</td>
    </tr>
    <tr>
        <td style="border-bottom:1px solid #ccc">Additional Info</td>
        <td style="border-bottom:1px solid #ccc">:</td>
        <td style="border-bottom:1px solid #ccc">
            Device : {{ \Agent::isMobile() ? 'Mobile' : (\Agent::isTablet() ? 'Tablet' : 'Desktop') }}<br>
            Browser : {{ request()->userAgent() }}<br>
            IP : {{ request()->getClientIp() }}
        </td>
    </tr>
</table>


