
class NamespaceBase {

	_namespace = false;
	_success_hook = '';

	namespace( suffix = '' ) {
		if ( ! this._namespace ) {
			console.log( this._namespace );
			throw new Error( `Illegal type of this._namespace: (${ typeof this._namespace })`, );
		}
		return ( this._namespace + suffix );
	};

	className( suffix = '' ) {
		return ( '.' + this.namespace( suffix ) );
	};

	setNamespace( value ) {
		if ( ! value ) {
			throw new Error( 'Please set the Namespace' );
		}
		this._namespace = this.parseNamespaceBeforeSave( value );

		return this;
	}

	setSuccessHook( hookName ) {
		this._success_hook = hookName;

		return this;
	}

	parseNamespaceBeforeSave( namespace ) {
		return namespace;
	}
}

export default NamespaceBase;