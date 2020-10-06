<span>
 {{ $address->street ?: '' }}<br />
 {{ $address->city ? $address->city . ', ' : '' }}{{ $address->state ?: '' }} {{ $address->zip ?: '' }}<br />
 {{ $address->country ?: '' }}
</span>
