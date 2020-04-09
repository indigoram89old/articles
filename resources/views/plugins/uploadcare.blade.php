@push('js')
	<script>UPLOADCARE_PUBLIC_KEY = "{{ config('services.uploadcare.public_key') }}";</script>
	<script src="https://ucarecdn.com/libs/widget/3.x/uploadcare.min.js"></script>
@endpush