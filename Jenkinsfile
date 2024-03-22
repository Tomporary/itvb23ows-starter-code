pipeline {
    agent any
    stages {
        stage('Build') {
            steps {
				echo 'Building'
                sh 'composer install'
            }
        }
		stage('Test') {
            steps {
                echo 'Testing'
            }
        }
        stage('Deploy') {
            steps {
                echo 'Deploying'
            }
        }
    }
	post {
		always {
			echo 'Pipeline finished'
		}
		success {
			echo 'Success'
		}
		failure {
			echo 'Failure'
		}
	}
}

