node {
	stage('SonarQube Analysis') {
		sh "/home/jenkins/tools/hudson.plugins.sonar.SonarRunnerInstallation/sonarqubescanner/bin/sonar-scanner -Dsonar.host.url=http://localhost:9009 -Dsonar.projectName=bakebadge -Dsonar.projectVersion=1.0 -Dsonar.projectKey=bakebadge:prj"
	}
}
