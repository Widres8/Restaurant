@section('footer')
<footer class="footer">
    <div class="footer-block author">
        <ul>
            <li> Creado por
                <a href="https://widres8.github.io/" target="_blank">Widres</a>
            </li>
            <li>&copy;
                <a href="{{ route('home') }}">{{ config('app.name', 'Asha Victoria Enterprises') }}</a>
            </li>
        </ul>
    </div>
</footer>
@endsection()
