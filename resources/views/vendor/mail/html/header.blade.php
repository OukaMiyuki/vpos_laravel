@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Visioner')
<img src="https://i.imgur.com/OVONl5a.png" class="logo" alt="Visioner Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
