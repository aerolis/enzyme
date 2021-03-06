attribute vec3 aVertexPosition;
attribute float aAmbientOcclusion;

uniform mat4 uMVMatrix;
uniform mat4 uVMatrix;
uniform mat4 uPMatrix;
uniform mat3 uNMatrix;

varying vec4 vPosition;
varying float vAmbientOcclusion;

void main(void) 
{
	vPosition = uMVMatrix * vec4(aVertexPosition, 1.0);
	gl_Position = uPMatrix * uVMatrix * vPosition;

	vAmbientOcclusion = aAmbientOcclusion;
}

