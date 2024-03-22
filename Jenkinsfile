pipeline {
    agent any
    stages {
        stage('Build') {
            steps {
				echo 'Building'
                sh 'docker compose'
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
}

