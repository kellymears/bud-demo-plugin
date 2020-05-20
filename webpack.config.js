const {readdirSync, statSync} = require('fs')
const {join, resolve} = require('path')
const AssetsPlugin = require('assets-webpack-plugin')
const {CleanWebpackPlugin} = require('clean-webpack-plugin')
const DependencyExtractionPlugin = require('@wordpress/dependency-extraction-webpack-plugin')
const FriendlyErrorsPlugin = require('friendly-errors-webpack-plugin')
const ManifestPlugin = require('webpack-manifest-plugin')
const MiniCssExtractPlugin = require('mini-css-extract-plugin')
const UglifyJsPlugin = require('uglifyjs-webpack-plugin')
const {HotModuleReplacementPlugin, NoEmitOnErrorsPlugin} = require('webpack')
const WebpackBar = require('webpackbar')
const WriteFilePlugin = require('write-file-webpack-plugin')

/**
 * Webpack utilities
 *
 * @return {bool}
 */
const isProduction = process.env.NODE_ENV === 'production'
const isHMR = process.env.NODE_ENV === 'hmr'

/**
 * Return array of directories
 *
 * @param  {string} parentDir
 * @return {array}
 */
const dirs = parentDir =>
  readdirSync(resolve(__dirname, parentDir)).filter(file =>
    statSync(join(parentDir, file)).isDirectory(),
  )

/**
 * Webpack Configuration
 */
module.exports = {
  entry: (assets = []) => {
    dirs('src/blocks').forEach(asset => {
      assets = {
        ...assets,
        [`${asset}/editor`]: [join(__dirname, `src/blocks/${asset}/editor.js`)],
        [`${asset}/public`]: [join(__dirname, `src/blocks/${asset}/public.js`)],
      }
    })

    dirs('src/extensions').forEach(asset => {
      assets = {
        ...assets,
        [`${asset}/editor`]: [join(__dirname, `src/blocks/${asset}/editor.js`)],
        [`${asset}/public`]: [join(__dirname, `src/blocks/${asset}/public.js`)],
      }
    })

    return assets
  },
  context: join(__dirname, 'src'),
  devServer: {
    disableHostCheck: true,
  },
  output: {
    path: resolve(__dirname, 'dist'),
    publicPath: '/dist/',
    filename: '[name].[hash].js',
    chunkFilename: '[id].css',
    sourceMapFilename: '[file].map',
  },
  devtool: isProduction ? false : 'inline-source-map',
  mode: isProduction ? 'production' : 'development',
  resolve: {
    alias: {
      '@blocks': resolve(__dirname, 'src/blocks'),
      '@components': resolve(__dirname, 'src/components'),
      '@extensions': resolve(__dirname, 'src/extensions'),
      '@hooks': resolve(__dirname, 'src/hooks'),
    },
    extensions: ['.js', '.json', '.jsx', '.css'],
    modules: [resolve(__dirname, 'node_modules')],
  },
  optimization: {
    minimizer: isProduction ? [new UglifyJsPlugin()] : [],
    splitChunks: {
      chunks: 'all',
    },
  },
  stats: {
    all: false,
    assets: true,
    errors: true,
    timings: true,
  },
  target: 'web',
  watch: global.watch || false,
  module: {
    rules: [
      {
        test: /\.(js|jsx)$/,
        include: join(__dirname, 'src'),
        use: [{loader: 'babel-loader'}, {loader: 'eslint-loader'}],
      },
      {
        test: /\.css$/,
        include: join(__dirname, 'src'),
        use: [
          {
            loader: MiniCssExtractPlugin.loader,
            options: {name: '[name].[hash].[ext]'},
          },
          {loader: 'css-loader'},
          {loader: 'postcss-loader'},
        ],
      },
      {
        test: /\.jpe?g$|\.gif$|\.png$/i,
        use: [
          {
            loader: 'file-loader',
            options: {name: '[path][name].[ext]'},
          },
        ],
      },
      {
        test: /\.svg$/,
        use: ['@svgr/webpack', 'url-loader'],
      },
    ],
  },
  plugins: [
    new MiniCssExtractPlugin({
      filename: '[name].[hash].css',
      chunkFilename: '[id].css',
    }),
    new CleanWebpackPlugin(),
    new DependencyExtractionPlugin({
      injectPolyfill: false,
      outputFormat: 'json',
    }),
    new ManifestPlugin({
      path: join(__dirname, 'dist'),
      writeToFileEmit: true,
      chunkFilename: 'manifest.json',
    }),
    new AssetsPlugin({
      path: join(__dirname, 'dist'),
      filename: 'assets.json',
      prettyPrint: true,
    }),
    new FriendlyErrorsPlugin(),
    ...(isHMR
      ? [new HotModuleReplacementPlugin(), new NoEmitOnErrorsPlugin(), new WriteFilePlugin()]
      : [new WebpackBar()]),
  ],
}
