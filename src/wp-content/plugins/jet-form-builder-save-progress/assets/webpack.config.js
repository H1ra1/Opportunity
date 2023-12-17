const path = require( 'path' );
const webpack = require( 'webpack' );
const { VueLoaderPlugin } = require( 'vue-loader' );

module.exports = {
	name: 'js_bundle',
	context: path.resolve( __dirname, 'src' ),
	entry: {
		'builder': './jet-form-builder/editor/main.js',
		'engine': './jet-engine/main.js',
		'deprecated.frontend': './deprecated.frontend/main.js',
		'jet.fb.frontend': './jet-form-builder/frontend/main.js',
	},
	output: {
		path: path.resolve( __dirname, 'dist' ),
		filename: '[name].bundle.js'
	},
	devtool: 'inline-cheap-module-source-map',
	resolve: {
		modules: [
			path.resolve( __dirname, 'src' ),
			'node_modules'
		],
		extensions: [ '.js', '.vue' ],
		alias: {
			'@': path.resolve( __dirname, 'src' ),
			'root': path.resolve( __dirname, '../../' )
		}
	},
	externals: {
		jquery: 'jQuery'
	},
	plugins: [
		new VueLoaderPlugin()
	],
	module: {
		rules: [
			{
				test: /\.js$/,
				loader: 'babel-loader',
				exclude: /node_modules/
			},
			{
				test: /\.vue$/,
				loader: 'vue-loader'
			},
		]
	},
	optimization: {
		splitChunks: {
			chunks: 'all'
		}
	},
}