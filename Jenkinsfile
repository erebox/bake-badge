node {
	stage('SonarQube Analysis') {
		sh "/var/jenkins_home/sonarscanner/bin/sonar-scanner -Dsonar.host.url=http://localhost:9000 -Dsonar.projectName=bakebadge -Dsonar.projectVersion=1.0 -Dsonar.projectKey=bakebadge:prj"
	}
}
