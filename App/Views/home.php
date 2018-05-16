<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>My Torrent Browser</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
</head>
<body>

    <div class="container mt-5 mb-5">

        <form class="form js-torrent-form">
            <div class="form-group">
                <label for="">Find Torrent</label>
                <div class="input-group mb-3">
                    <input type="text" class="form-control js-torrent-search input-lg" placeholder="Supernatural, The Walking Dead, ...">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit">Search</button>
                    </div>
                </div>
            </div>
        </form>

        <div class="list-group js-torrent-result d-none"></div>

        <div class="trending-movies mt-5">
            <div class="mb-2">Trending Movies <small class="text-muted">(from YTS.to)</small></div>
            <div class="list-group">
              <?php foreach ($trendingMovies as $movie) : ?>
                  <a href="#" class="list-group-item list-group-item-action js-trending-movie-btn" data-keyword="<?= $movie->getKeyword() ?>" title="<?= $movie->getDisplayTitle() ?>">
                      <?= $movie->getDisplayTitle() ?>
                  </a>
              <?php endforeach ?>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js"></script>

    <script id="js-torrent-list--template-result" type="x-tmpl-mustache">
    <a href="{{ url }}" class="clearfix list-group-item js-torrent-show-magnet">
        {{ title }}

        <span title="File Size" class="float-right badge badge-primary badge-pill">{{ size }}</span>
        <span title="Seeder" class="mr-2 float-right badge badge-success badge-pill">{{ seed }}</span>
        <span title="Leeches" class="mr-2 float-right badge badge-danger badge-pill">{{ leeches }}</span>
    </a>
    </script>

    <script id="js-torrent-list--template-alert-danger" type="x-tmpl-mustache">
    <div class="alert alert-danger" role="alert">
        {{ message }}
    </div>
    </script>

    <script type="text/javascript">
    var $form = $('.js-torrent-form');
    var $search = $('.js-torrent-search');
    var $result = $('.js-torrent-result');
    var $btn_magnet_action = $('.js-torrent-btn-magnet');
    var $btn_magnet_show = $('.js-torrent-show-magnet');
    var $btn_magnet_modal = $('.js-torrent-modal-show-magnet');

    /**
     * Mustache View Render
     */
    // Result
    var template_result = $('#js-torrent-list--template-result').html();
    Mustache.parse(template_result);

    // Alert Danger
    var template_alert_danger = $('#js-torrent-list--template-alert-danger').html();
    Mustache.parse(template_alert_danger);

    $(document).on('click', '.js-torrent-show-magnet', function(e) {

        e.preventDefault();

        $.ajax({
            url: '/api',
            data: {
                detail: $(this).attr('href')
            },
            success: function(url) {

                var wnd = window.open(url);
                setTimeout(function() {
                    wnd.close();
                }, 250)
            },
            error: function(a, b, c, d) {

                $result.html(Mustache.render(template_alert_danger, {
                    message: `ERROR --- ${a}, ${b}, ${c}, ${d}`
                }));
                console.log('ERROR', a, b, c, d);
            }
        });


    });

    $form.on('submit', function(e) {
        e.preventDefault();

        $result
            .addClass('d-none')
            .html('');

        $.ajax({
            url: '/api',
            data: {
                search: $search.val()
            },
            success: function(list) {

                if (!list.length) {
                    $result
                        .html(Mustache.render(template_alert_danger, {
                            message: `No result found.`
                        }))
                        .removeClass('d-none');
                    return;
                }

                console.log(list);
                $result.removeClass('d-none');
                var html = '';
                $.each(list, function(index, item) {
                    console.log(item);
                    html = html + Mustache.render(template_result, item);
                });
                $result.html(html);
            },
            error: function(a, b, c, d) {
                console.log('ERROR', a, b, c, d);
            }
        });
    });

    $('.js-trending-movie-btn').on('click', function(e) {
        e.preventDefault();
        var $this = $(this);
        var keyword = $this.data('keyword');
        console.log(keyword);

        $('html, body').animate({
            scrollTop: 0
        }, 100);
        $search.val(keyword);
        $form.submit();
    });

    </script>

</body>
</html>
