const path = require( 'path' );
const webpack = require( 'webpack' );
const { VueLoaderPlugin } = require( 'vue-loader' );

module.exports = {
	name: 'js_bundle',
	context: path.resolve( __dirname, 'src' ),
	entry: {
		'builder.editor': './jet-form-builder/editor/main.js',
		'builder.admin': './jet-form-builder/admin/main.js',
		'engine.editor': './jet-engine/editor/main.js',
		'engine.admin': './jet-engine/admin/main.js',
	},
	output: {
		path: path.resolve( __dirname, 'dist' ),
		filename: '[name].bundle.js'
	},
	devtool: 'source-map',
	resolve: {
		modules: [
			path.resolve( __dirname, 'blocks' ),
			path.resolve( __dirname, 'src' ),
			'node_modules'
		],
		extensions: [ '.js', '.vue' ],
		alias: {
			'@': path.resolve( __dirname, 'src' ),
			'@blocks': path.resolve( __dirname, 'blocks' )
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
	/*optimization: {
		splitChunks: {
			chunks: 'all'
		}
	},*/
}