@setup

  $user = 'acorn2';
  $timezone = 'Europe/Kiev';
  $path = '/var/www/telegrambot';
  $current = $path . '/current';
  $repo = 'git@bitbucket.org:2222k/bot-kicker-freekassa.git';
  $branch = 'master';
  $chmods = [
    'storage/logs'
  ];

  $date = new DateTime('now', new DateTimeZone($timezone));
  $release = $path . '/releases/' . $date->format('YmdHis');
@endsetup
@servers(['production' => $user . '@77.222.63.44', 'localhost'  => $user . '@127.0.0.1'])

@task('clone', ['on' => $on])
  mkdir -p {{ $release }}
  git clone --depth 1 -b {{ $branch }} "{{ $repo }}" {{ $release }}

  echo "#1 - Repository has been cloned";
@endtask

@task('composer', ['on' => $on])
  cd {{ $release }}
  composer install --no-interaction --no-dev --prefer-dist

  echo "#2 - Composer dependencies have been instaled";
@endtask

@task('artisan', ['on' => $on])
  cd {{ $release }}
  ln -nfs {{ $path }}/.env .env;
  chgrp -h www-data .env;
  php artisan config:clear
  php artisan migrate

  echo "#3 - Artisan commands have been run"
@endtask

@task('npm', ['on' => $on])
  cd {{ $release }}
  npm install
  npm run prod

  echo "#4 - Npm commands have been run"
@endtask

@task('chmod', ['on' => $on])
  chgrp -R www-data {{ $release }};
  chmod -R ug+rwx {{ $release }};
  @foreach ($chmods as $file)
    chmod -R 775 {{ $release }}/{{ $file }}
    chown -R {{ $user }}:www-data {{ $release }}/{{ $file }}
    echo "Permissions have been set for {{ $file }}"
  @endforeach

  echo "#5 - Permissions have been set"
@endtask

@task('update_symlinks')
  ln -nfs {{ $release }} {{ $current }};
  chgrp -h www-data {{ $current }};

  echo "#6 - Symlink has been set"
@endtask

@macro('deploy', ['on' => 'production'])
  clone
  composer
  artisan
  npm
  chmod
  update_symlinks
@endmacro
