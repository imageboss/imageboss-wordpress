function ibup_mountImageBossUrl(src, { operation, cover_mode, width, height, options }) {
  var serviceUrl = 'https://img.imageboss.me';
  var template = '/:operation/:options/';

  if (operation === 'cover') {
    template = '/:operation::cover_mode/:widthx:height/:options/';
  } else if (operation === 'width') {
    template = '/:operation/:width/:options/';
  } else if (operation === 'height') {
    template = '/:operation/:height/:options/';
  }

  var finalUrl = template
    .replace(':operation', operation || 'cdn')
    .replace(':cover_mode', cover_mode || '')
    .replace(':width', width || '')
    .replace(':height', height || '')
    .replace(':options', options || '')
    .replace(/\/\//g, '/')
    .replace(/:\//g, '/')

  return serviceUrl + finalUrl + src;
}
