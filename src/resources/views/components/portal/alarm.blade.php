<div class="artykul_alarm">
    <div class="box-wrapper">
        <div class="tytul">
            <h2>Światrolnika alarm</h2>
        </div>
        <div class="alarm_text">
            <span class="title">Światrolnika alarm!</span>
            <p>Jeśli byłeś świadkiem niecodziennego zdarzenia związanego z Twoim gospodarstwem lub rolnictwem, skontaktuj się z nami, prześlij zdjęcia lub video z opisem sytuacji. My już będziemy wiedzieć co z tym zrobić! Na zgłoszenia odpowiadamy całą dobę, 7 dni w tygodniu.</p>
            <span class="e-mail">redakcja@swiatrolnika.info</span>
        </div>
    </div>
    <div class="zdjecie">
        <div class="zdjecie_bg">
                <div class="fotka_alarm">
                    {!!App\Classes\Images::mainImage($artykul)!!}
                </div>
                <div class="zdjecie_tytul">
                    <h3>
                        <a href="{{ Config::get('app.url') }}/{{ $artykul->category->path.'/'.$artykul->alias }}.html">{{$artykul->title}}</a>
                    </h3>
                </div>
            </div>
    </div>
</div>
