pipeline {
    agent any
    stages {
        stage('Build') {
            steps {
				echo 'Building'
            }
        }
		stage('SonarQube Analysis') {
			steps {
				script { scannerHome = tool 'Ontwikkelstraat-scanner'; }
				withSonarQubeEnv('SonarQube') {
					sh "${scannerHome}/bin/sonar-scanner
						-Dsonar.projectKey=Ontwikkelstraten"
				}
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

