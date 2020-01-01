const path = require('path');

module.exports = {

    entry: './test-webpack/app/app.js',

    output: {

      path: path.resolve(__dirname, 'dist'),

      filename: 'bundle.js'

    }

  };